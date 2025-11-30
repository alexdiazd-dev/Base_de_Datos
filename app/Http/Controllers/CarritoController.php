<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    /* ============================================================
       OBTENER EL CARRITO ACTUAL
    ============================================================ */
    public function obtenerCarrito()
    {
        try {
            $carrito = session()->get('carrito', []);

            foreach ($carrito as &$item) {
                // Si no existe o viene vacA-o, regenerarlo
                if (!isset($item['imagen_url']) || empty($item['imagen_url'])) {
                    $item['imagen_url'] = asset('storage/productos/' . $item['imagen']);
                }
            }

            return response()->json([
                'carrito' => $carrito,
                'total' => $this->calcularTotal($carrito)
            ]);
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }


    /* ============================================================
       AGREGAR PRODUCTO AL CARRITO
    ============================================================ */
    public function agregar(Request $request, $id)
    {
        try {
            $producto = Producto::find($id);

            if (!$producto) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $carrito = session()->get('carrito', []);

            // Si ya estA� en el carrito �+' aumentar cantidad
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad'] += 1;
            } 
            else {
                // Agregar producto nuevo
                $carrito[$id] = [
                    'id'       => $producto->id_producto,
                    'nombre'   => $producto->nombre,
                    'precio'   => $producto->precio,
                    'imagen_url' => asset('storage/' . $producto->imagen),
                    'imagen'   => $producto->imagen,
                    'cantidad' => 1
                ];
            }

            session()->put('carrito', $carrito);

            return response()->json([
                'mensaje' => 'Producto agregado',
                'carrito' => $carrito,
                'total'   => $this->calcularTotal($carrito)
            ]);
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* ============================================================
       ACTUALIZAR CANTIDAD
    ============================================================ */
    public function actualizarCantidad(Request $request, $id)
    {
        try {
            $carrito = session()->get('carrito', []);

            if (!isset($carrito[$id])) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $cantidad = max(1, intval($request->cantidad));
            $carrito[$id]['cantidad'] = $cantidad;

            session()->put('carrito', $carrito);

            return response()->json([
                'mensaje' => 'Cantidad actualizada',
                'carrito' => $carrito,
                'total'   => $this->calcularTotal($carrito)
            ]);
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* ============================================================
       ELIMINAR UN PRODUCTO DEL CARRITO
    ============================================================ */
    public function eliminar($id)
    {
        try {
            $carrito = session()->get('carrito', []);

            if (isset($carrito[$id])) {
                unset($carrito[$id]);
            }

            session()->put('carrito', $carrito);

            return response()->json([
                'mensaje' => 'Producto eliminado',
                'carrito' => $carrito,
                'total'   => $this->calcularTotal($carrito)
            ]);
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* ============================================================
       VACIAR TODO EL CARRITO
    ============================================================ */
    public function vaciar()
    {
        try {
            session()->forget('carrito');

            return response()->json([
                'mensaje' => 'Carrito vaciado',
                'carrito' => [],
                'total'   => 0
            ]);
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /* ============================================================
       CALCULAR TOTAL DEL CARRITO
    ============================================================ */
    private function calcularTotal($carrito)
    {
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return number_format($total, 2, '.', '');
    }
}
