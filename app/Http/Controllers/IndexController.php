<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class IndexController extends Controller
{
    public function inicio(Request $request)
    {
        try {
            $categoria = $request->input('categoria', 'todas');
            $orden = $request->input('orden', 'nombre_asc');

            $query = Producto::with('categoria');

            if ($categoria !== 'todas') {
                $query->where('id_categoria', $categoria);
            }

            switch ($orden) {
                case 'precio_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                default:
                    $query->orderBy('nombre', 'asc');
            }

            $productos = $query->get();
            $productos_totales = $query->count();
            $categorias = Categoria::all();

            return view('index', compact('productos','productos_totales', 'categorias', 'categoria', 'orden'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function detalleProducto($id) {
        try {
            $producto = Producto::with('categoria')->findOrFail($id);
            return view('detalles', compact('producto'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

}
