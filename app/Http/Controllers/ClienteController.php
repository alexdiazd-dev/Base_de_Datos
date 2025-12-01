<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Personalizacion;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{

    // CatA�logo
    public function catalogo(Request $request)
    {
        try {
            $categoria = $request->input('categoria', 'todas');
            $orden = $request->input('orden', 'nombre_asc');
            $buscar = $request->input('buscar');


            $query = Producto::with('categoria');

            if ($categoria !== 'todas') {
                $query->where('id_categoria', $categoria);
            }
            if ($buscar) {
                $query->where(function($q) use ($buscar) {
                    $q->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
                });
            }

            switch ($orden) {
                case 'precio_asc':
                    $query->orderBy('precio', 'asc');
                    break;

                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;

                case 'nombre_asc':
                default:
                    $query->orderBy('nombre', 'asc');
                    break;
            }
            $productos = $query->get();
            $productos_totales = $query->count();
            $categorias = Categoria::all();
            return view('cliente.catalogo.productos', compact('productos', 'productos_totales', 'categorias', 'categoria', 'orden'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
        
    }
    public function detalleProducto($id) {
        try {
            $producto = Producto::with('categoria')->findOrFail($id);
            return view('cliente.catalogo.ver-detalles', compact('producto'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
    // Pedidos
    public function verPedidos()
    {
        try {
            $usuarioId = session('usuario_id');

            // Traer pedidos del usuario correcto
            $pedidos = Pedido::where('id_usuario', $usuarioId)
                ->with(['detalles.producto'])
                ->get()
                ->map(function($pedido) {

                    $primerItem = $pedido->detalles->first();

                    $pedido->image_url = $primerItem && $primerItem->producto->imagen
                        ? asset('storage/' . $primerItem->producto->imagen)
                        : asset('images/sin-imagen.png');  // imagen por defecto

                    $pedido->producto_nombre = $primerItem ? $primerItem->producto->nombre : 'Producto';
                    $pedido->cantidad = $primerItem ? $primerItem->cantidad : 1;

                    // estado_class dinA�mico
                    $pedido->estado_class = match($pedido->estado) {
                        'Pendiente'     => 'text-warning',
                        'Preparación'   => 'text-info',
                        'Enviado'       => 'text-primary',
                        'Entregado'     => 'text-success',
                        'Cancelado'     => 'text-danger',
                        default         => 'text-secondary',
                    };

                    // si no existe fecha de entrega
                    $pedido->fecha_entrega = $pedido->fecha_pedido;

                    return $pedido;
                });

            return view('cliente.pedidos.lista-pedidos', compact('pedidos'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }

    }
    
    public function detallesPedidos($id){
    try {
        $pedido = Pedido::with(['detalles', 'usuario'])->findOrFail($id);

        return view('cliente.pedidos.pedidos-detalles', compact('pedido'));
    } catch (\Throwable $e) {
        report($e);
        throw $e;
    }
    }

    public function detalleInline($id)
{
    try {
        $usuarioId = session('usuario_id');

        $pedido = Pedido::where('id_usuario', $usuarioId)
            ->with(['detalles.producto', 'envio'])
            ->findOrFail($id);

        return view('cliente.pedidos._detalle-inline', compact('pedido'));
    } catch (\Throwable $e) {
        report($e);
        throw $e;
    }
}



    // Productos personalizados
    public function personalizados()
    {
        try {
            $id_usuario = session('usuario_id');

            // Obtener los personalizados del cliente
            $personalizados = Personalizacion::where('id_usuario', $id_usuario)
                ->orderBy('fecha_solicitud', 'desc')
                ->get();

            return view('cliente.personalizados.lista-personalizado', compact('personalizados'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
    public function nuevaSolicitud()
    {
        try {
            // No requiere datos dinA�micos por ahora
            return view('cliente.personalizados.personalizado-crear');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    // SimulaciA3n de envA-o del formulario
    public function guardarSolicitud(Request $request)
    {
        try {
            // Verificar autenticaciA3n
            if (!session()->has('usuario_id')) {
                // Guardar datos del formulario en sesiA3n antes de redirigir
                session(['form_personalizado' => $request->except('_token', 'imagen_referencia')]);
                session(['url.intended' => route('cliente.personalizados.nueva')]);
                
                return redirect()->route('login')
                    ->with('error', 'Debes iniciar sesión para enviar una solicitud personalizada.');
            }

            // ValidaciA3n
            $request->validate([
                'descripcion' => 'required|string|max:500',
                'tamano' => 'required|string|max:50',
                'sabor' => 'required|string|max:50',
                'ocasion' => 'nullable|string|max:50',
                'imagen_referencia' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
                'notas_adicionales' => 'nullable|string|max:500'
            ]);

            // Subida de imagen (si el cliente envA-a una)
            $rutaImagen = null;
        
            if ($request->hasFile('imagen_referencia')) {
                $rutaImagen = $request->file('imagen_referencia')->store('personalizados', 'public');
            }

            // === ALGORITMO DE ESTIMACIA"N DE PRECIO ===

            // Precios por tamaA�o
            $preciosTamano = [
                'Pequeño (15cm)' => 35,
                'Mediano (20cm)' => 55,
                'Grande (3 pisos)' => 120
            ];

            // Adicionales por sabor
            $preciosSabor = [
                'Vainilla' => 0,
                'Chocolate' => 5,
                'Red Velvet' => 10,
                'Fresa' => 5,
                'Combinado' => 12,
            ];

            // Adicionales por ocasiA3n
            $preciosOcasion = [
                'Cumpleaños' => 0,
                'Boda' => 25,
                'Aniversario' => 10,
                'Corporativo' => 15,
                'Otro' => 5,
            ];

            $costo = 0;

            $costo += $preciosTamano[$request->tamano] ?? 0;
            $costo += $preciosSabor[$request->sabor] ?? 0;
            $costo += $preciosOcasion[$request->ocasion] ?? 0;
            

            // ==========================================

            $idUsuario = session('usuario_id');

            // Capturar imagen generada por IA de la sesión (si existe)
            $imagenIA = session('imagen_ia_generada');

            // Crear registro real en la base de datos
            $result = DB::select('CALL sp_insert_personalizacion(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $idUsuario,
                now(), // fecha_solicitud
                $request->descripcion,
                $request->tamano,
                $request->sabor,
                $request->ocasion,
                $rutaImagen,
                $request->notas_adicionales,
                $costo,
                'Pendiente',
            ]);

            // Si se generó imagen con IA, actualizarla en el registro recién creado
            if ($imagenIA) {
                $ultimaPersonalizacion = Personalizacion::where('id_usuario', $idUsuario)
                    ->orderBy('id_personalizacion', 'desc')
                    ->first();
                
                if ($ultimaPersonalizacion) {
                    $ultimaPersonalizacion->imagen_ia = $imagenIA;
                    $ultimaPersonalizacion->save();
                }
                
                // Limpiar imagen IA de la sesión
                session()->forget('imagen_ia_generada');
            }

            // Limpiar datos del formulario de la sesiA3n
            session()->forget('form_personalizado');

            return redirect()
                ->route('cliente.personalizados')
                ->with('success', 'Pedido a espera de confirmación');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function detallesPersonalizado($id)
    {
        try {
            $personalizado = Personalizacion::where('id_personalizacion', $id)
                ->where('id_usuario', session('usuario_id'))
                ->firstOrFail();

            return view('cliente.personalizados.personalizado-detalle', compact('personalizado'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function editarPersonalizado($id)
    {
        try {
            $personalizado = Personalizacion::where('id_personalizacion', $id)
                ->where('id_usuario', session('usuario_id'))
                ->firstOrFail();

            return view('cliente.personalizados.personalizado-editar', compact('personalizado'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function actualizarPersonalizado(Request $request, $id)
    {
        try {
            $personalizado = Personalizacion::where('id_personalizacion', $id)
                ->where('id_usuario', session('usuario_id'))
                ->firstOrFail(); // lectura: OK

            if (!in_array($personalizado->estado, ['Pendiente', 'En Diseño'])) {
                return back()->with('error', 'No puedes modificar una solicitud en este estado.');
            }

            $request->validate([
                'descripcion'        => 'required|string|max:500',
                'tamano'             => 'required|string|max:50',
                'sabor'              => 'required|string|max:50',
                'imagen_referencia'  => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
                'ocasion'            => 'nullable|string|max:50',
                'notas_adicionales'  => 'nullable|string|max:500',
            ]);

            // --- REGENERAR COSTO AUTOMÁTICAMENTE ---
            $preciosTamano = [
                'Pequeño (15cm)' => 35,
                'Mediano (20cm)' => 55,
                'Grande (3 pisos)' => 120
            ];

            $preciosSabor = [
                'Vainilla' => 0,
                'Chocolate' => 5,
                'Red Velvet' => 10,
                'Fresa' => 5,
                'Combinado' => 12,
            ];

            $preciosOcasion = [
                'Cumpleaños' => 0,
                'Boda' => 25,
                'Aniversario' => 10,
                'Corporativo' => 15,
                'Otro' => 5,
            ];

            $costo = 0;
            $costo += $preciosTamano[$request->tamano] ?? 0;
            $costo += $preciosSabor[$request->sabor] ?? 0;
            $costo += $preciosOcasion[$request->ocasion] ?? 0;

            // --- Manejo de imagen ---
            $rutaImagen = $personalizado->imagen_referencia;
            if ($request->hasFile('imagen_referencia')) {
                $rutaImagen = $request->file('imagen_referencia')->store('personalizados', 'public');
            }

            // --- LLAMADA AL SP COMPLETO ---
            DB::statement('CALL sp_update_personalizacion(?, ?, ?, ?, ?, ?, ?, ?)', [
                $personalizado->id_personalizacion,
                $request->descripcion,
                $request->tamano,
                $request->sabor,
                $request->ocasion ?? $personalizado->ocasion,
                $rutaImagen,
                $request->notas_adicionales ?? $personalizado->notas_adicionales,
                $costo,  // NUEVO: costo actualizado
            ]);

            return redirect()->route('cliente.personalizados.detalles', $id)
                ->with('success', 'Solicitud actualizada correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function eliminarPersonalizado($id)
    {
        try {
            $personalizado = Personalizacion::where('id_personalizacion', $id)
                ->where('id_usuario', session('usuario_id'))
                ->firstOrFail();

            if (!in_array($personalizado->estado, ['Pendiente', 'Rechazado'])) {
                return back()->with('error', 'No puedes eliminar una solicitud procesada o aprobada.');
            }

            DB::statement('CALL sp_delete_personalizacion(?)', [
            $personalizado->id_personalizacion
            ]);

            return redirect()->route('cliente.personalizados')
                ->with('success', 'Solicitud eliminada correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }
}
