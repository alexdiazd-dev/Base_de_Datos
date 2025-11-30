<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;

class AdminPedidoController extends Controller
{
    /**
     * Mostrar lista de pedidos del cliente (vista admin)
     */
    public function verPedidos()
    {
        try {
            // Traer pedidos con usuario y su primer producto
            $pedidos = Pedido::with(['usuario', 'detalles.producto', 'pago'])
                ->orderBy('id_pedido', 'DESC')
                ->get();

            // Generar una imagen por cada pedido (primer producto)
            foreach ($pedidos as $pedido) {
                $primerItem = $pedido->detalles->first();

                $pedido->image_url = $primerItem && $primerItem->producto
                    ? asset('storage/productos/' . $primerItem->producto->imagen)
                    : asset('images/no-image.png');

                $pedido->producto_nombre = $primerItem && $primerItem->producto
                    ? $primerItem->producto->nombre
                    : 'Producto eliminado';
            }

            return view('admin.pedidos.gestion-pedidos', compact('pedidos'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    /**
     * Mostrar detalles de un pedido específico
     */
    public function detallesPedido($id)
    {
        try {
            // Obtener pedido + usuario + detalles + productos
            $pedido = Pedido::with(['usuario', 'detalles.producto', 'pago'])
                ->findOrFail($id);

            return view('admin.pedidos.detalles-pedido', compact('pedido'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    /**
     * Actualizar estado desde el panel admin
     */
    public function actualizarEstado(Request $request, $id){
        try {
            $request->validate([
                'estado' => 'required|string'
            ]);

            // Solo validamos que exista (lectura)
            $pedido = Pedido::findOrFail($id);

            DB::statement('CALL sp_update_estado_pedido(?, ?)', [
                $pedido->id_pedido,
                $request->estado
            ]);

            return back()->with('ok', 'Estado actualizado');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

}
