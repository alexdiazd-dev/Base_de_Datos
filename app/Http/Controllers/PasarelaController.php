<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Pago;
use App\Models\Envio;
use Illuminate\Support\Facades\DB;

class PasarelaController extends Controller
{
    /* ============================================================
       CHECKOUT (GET) �+' carga la vista donde estA� TODO
    ============================================================ */
    public function pago()
    {
        try {
            $carrito = session('carrito', []);
            $subtotal = 0;
            $delivery = 6.00;
            $envio = 'Delivery';

            $usuarioNombre = session('nombre');
            $usuarioCorreo = session('correo');
            $usuarioApellido = session('apellido');
            $usuarioTelefono = session('telefono');

            foreach ($carrito as $item) {
                $subtotal += $item['precio'] * $item['cantidad'];
            }

            $total = $subtotal + $delivery;

            return view('cliente.pasarela.pago', compact(
                'carrito',
                'total',
                'subtotal',
                'delivery',
                'envio',
                'usuarioNombre',
                'usuarioCorreo',
                'usuarioApellido',
                'usuarioTelefono'
            ));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    /* ============================================================
       GUARDAR TODO (ENVA?O + PAGO + PEDIDO)
    ============================================================ */
    public function guardarPago(Request $request)
    {
        try {
            // VALIDACIÓN BASE
            $request->validate([
                'nombre'       => 'required|string',
                'apellidos'    => 'required|string',
                'correo'       => 'required|email',
                'telefono'     => 'required|digits:9',
                'direccion'    => 'required|string',
                'ciudad'       => 'required|string',
                'metodo'       => 'required|in:Yape,Tarjeta,Contra Entrega'
            ]);

            // VALIDACIONES SEGÚN MÉTODO
            if ($request->metodo === 'Tarjeta') {
                $request->validate([
                    'tarjeta_numero' => 'required|digits:16',
                    'tarjeta_nombre' => ['required','regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/'],
                    'tarjeta_fecha'  => ['required','regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
                    'tarjeta_cvv'    => 'required|digits:3',
                ]);
            }

            if ($request->metodo === 'Contra Entrega') {
                $request->validate([
                    'efectivo_billete' => 'nullable|string'
                ]);
            }

            $carrito = session('carrito', []);
            if (empty($carrito)) {
                return redirect()->route('cliente.catalogo')
                    ->with('error', 'Tu carrito está vacío.');
            }

            // CALCULAR TOTAL
            $subtotal = 0;
            foreach ($carrito as $item) {
                $subtotal += $item['precio'] * $item['cantidad'];
            }

            $delivery = 6.00;
            $total = $subtotal + $delivery;

            $pedidoId = null;

            DB::transaction(function () use ($request, $carrito, $total, &$pedidoId) {

                /* ============================================================
                1) CREAR PEDIDO (SP) — VALIDAR RETORNO OBLIGATORIO
                ============================================================ */
                $resPedido = DB::select('CALL sp_insert_pedido(?, ?, ?)', [
                    session('usuario_id'),
                    $total,
                    'Pendiente',
                ]);

                if (!$resPedido || !isset($resPedido[0]->id_pedido)) {
                    throw new \Exception("Error crítico: el Stored Procedure sp_insert_pedido no retornó un id_pedido.");
                }

                $pedidoId = $resPedido[0]->id_pedido;

                /* ============================================================
                2) CREAR ENVÍO (SP)
                ============================================================ */
                DB::statement('CALL sp_insert_envio(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                    $pedidoId,
                    $request->nombre,
                    $request->apellidos,
                    $request->telefono,
                    $request->correo,
                    $request->direccion,
                    $request->ciudad,
                    $request->metodo,
                    6.00,
                    $request->notas ?? null,
                ]);

                /* ============================================================
                3) CREAR DETALLES DEL PEDIDO (SP)
                ============================================================ */
                foreach ($carrito as $item) {
                    DB::statement('CALL sp_insert_detalle_pedido(?, ?, ?, ?)', [
                        $pedidoId,
                        $item['id'],
                        $item['cantidad'],
                        $item['precio'] * $item['cantidad'],
                    ]);
                }

                /* ============================================================
                4) REGISTRAR PAGO (SP)
                ============================================================ */
                DB::statement('CALL sp_insert_pago(?, ?, ?)', [
                    $pedidoId,
                    $request->metodo,
                    $total,
                ]);
            });

            // GUARDAR ID PARA CONFIRMACIÓN
            session(['pedido_id' => $pedidoId]);

            // LIMPIAR CARRITO
            session()->forget('carrito');

            // IR A CONFIRMACIÓN
            return redirect()->route('cliente.pasarela.confirmacion');

        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    /* ============================================================
       CONFIRMACIA"N FINAL (GET)
    ============================================================ */
    
    public function confirmacion()
    {
        try {
            $pedidoId = session('pedido_id');

            if (!$pedidoId) {
                return redirect()->route('cliente.catalogo');
            }

            $pedido = Pedido::with(['detalles.producto', 'envio', 'pago'])
                ->find($pedidoId);

            return view('cliente.pasarela.confirmacion', compact('pedido'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


}
