<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        try {
            // Guardar la URL de origen si no hay sesiA3n activa
            if (!session()->has('usuario_id') && !session()->has('url.intended')) {
                $prev = url()->previous();
                // Solo guardar si no viene de login o registro
                if ($prev && !str_contains($prev, '/login') && !str_contains($prev, '/registro')) {
                    session(['url.intended' => $prev]);
                }
            }
            
            return view('registro');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:80',
                'apellido' => 'required|string|max:80',
                'correo' => 'required|email|unique:usuarios,correo',
                'telefono' => 'required|string|min:9|max:9',
                'contraseña' => 'required|string|min:6|confirmed',
            ]);

            $usuario = new Usuario();
            $usuario->id_rol = 2; 
            $usuario->nombre = $validated['nombre'];
            $usuario->apellido = $validated['apellido'];
            $usuario->correo = $validated['correo'];
            $usuario->telefono = $validated['telefono'];
            $usuario->contraseña = Hash::make($validated['contraseña']);
            $usuario->save();

            // Mantener la URL intended si existe y no apunta a registro
            $intended = session('url.intended');
            if ($intended && str_contains($intended, '/registro')) {
                session()->forget('url.intended');
            }

            return redirect()->route('login')
                   ->with('success', 'Cuenta creada correctamente. Ahora puedes iniciar sesión.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function showLogin(Request $request)
    {
        try {
            if (!session()->has('usuario_id')) {
                // Prioridad al parA�metro 'back' en la URL
                $back = $request->query('back');

                if ($back) {
                    $decoded = urldecode($back);
                    if ($decoded && !str_contains($decoded, '/login') && !str_contains($decoded, '/registro')) {
                        session(['url.intended' => $decoded]);
                    }
                } 
                // Si no hay 'back' y no hay intended guardado, usar previous
                elseif (!session()->has('url.intended')) {
                    $prev = url()->previous();
                    if ($prev && !str_contains($prev, '/login') && !str_contains($prev, '/registro')) {
                        session(['url.intended' => $prev]);
                    }
                }
            }
            return view('login');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'correo' => 'required|email',
                'contraseña' => 'required|string'
            ]);

            $usuario = Usuario::where('correo', $validated['correo'])->first();

            if ($usuario && Hash::check($validated['contraseña'], $usuario->contraseña)) {

                // Guardar todos los datos que usarA�s mA�s adelante
                session([
                    'usuario_id' => $usuario->id_usuario,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'correo' => $usuario->correo,
                    'telefono' => $usuario->telefono,   // ← AÑADIDO
                    'rol' => $usuario->id_rol
                ]);

                // Si es admin
                if ($usuario->id_rol == 1) {
                    session()->forget('url.intended');
                    return redirect()->route('admin.productos')
                        ->with('success', 'Bienvenido administrador.');
                }

                // Cliente: usar url.intended
                $intended = session('url.intended');
                session()->forget('url.intended');

                // Validar que la URL intended sea segura
                if ($intended) {
                    $host = $request->getSchemeAndHttpHost();
                    $isSameHost = Str::startsWith($intended, $host);
                    $isRelative = Str::startsWith($intended, '/');

                    if (($isSameHost || $isRelative) && 
                        !str_contains($intended, '/login') && 
                        !str_contains($intended, '/registro')) {
                        return redirect()->to($intended)->with('success', 'Bienvenido de nuevo.');
                    }
                }

                return redirect()->route('cliente.catalogo')
                    ->with('success', 'Bienvenido a D’Nokali.');
            }

            return back()
                ->withErrors(['correo' => 'Credenciales incorrectas'])
                ->withInput();
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->session()->flush();         
            $request->session()->invalidate();    
            $request->session()->regenerateToken();

            return redirect()->route('index');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}
