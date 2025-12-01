<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Personalizacion;
use App\Models\Usuario;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function productos(Request $request) {
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

                case 'nombre_asc':
                default:
                    $query->orderBy('nombre', 'asc');
                    break;
            }
            $productos = $query->get();
            $productos_totales = $query->count();
            $categorias = Categoria::all();
            return view('admin.productos.producto', compact('productos', 'productos_totales', 'categorias', 'categoria', 'orden'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function formAgregarProducto() {
        try {
            $categorias = Categoria::all();
            return view('admin.productos.agregarProducto', compact('categorias'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function storeProducto(Request $request){
        try {
            $validatedData = $request->validate([
                'id_categoria' => 'required|exists:categorias,id_categoria',
                'nombre'       => 'required|string|max:120',
                'descripcion'  => 'nullable|string|min:0|max:500',
                'precio'       => 'required|numeric|min:0.1',
                'imagen'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'estado'       => 'required|in:Disponible,Agotado'
            ]);

            // Manejo de imagen como ya lo tienes
            $imagenPath = null;
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('productos', 'public');
            }

            // LLAMADA AL SP
            $result = DB::select('CALL sp_insert_producto(?, ?, ?, ?, ?, ?)', [
                $validatedData['id_categoria'],
                $validatedData['nombre'],
                $validatedData['descripcion'] ?? null,
                $validatedData['precio'],
                $imagenPath,
                $validatedData['estado'],
            ]);

            // Opcional: obtener id_producto
            // $idProducto = $result[0]->id_producto ?? null;

            return redirect()
                ->route('admin.productos')
                ->with('success', '✅ Producto agregado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function detalleProducto($id) {
        try {
            $producto = Producto::with('categoria')->findOrFail($id);
            return view('admin.productos.detalleProducto', compact('producto'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function formEditarProducto($id) {
        try {
            $producto = Producto::findOrFail($id);
            $categorias = Categoria::all();
            return view('admin.productos.editarProducto', compact('producto', 'categorias'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function updateProducto(Request $request, $id) {
        try {
            $producto = Producto::findOrFail($id); // lectura OK con Eloquent

            $validatedData = $request->validate([
                'id_categoria' => 'required|exists:categorias,id_categoria',
                'nombre'       => 'required|string|max:120',
                'descripcion'  => 'nullable|string|min:0|max:500',
                'precio'       => 'required|numeric|min:0.1',
                'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'estado'       => 'required|in:Disponible,Agotado'
            ]);

            // Manejo de imagen
            $imagenPath = $producto->imagen;
            if ($request->hasFile('imagen')) {
                if ($producto->imagen) {
                    Storage::disk('public')->delete($producto->imagen);
                }
                $imagenPath = $request->file('imagen')->store('productos', 'public');
            }

            // LLAMAR AL SP
            DB::statement('CALL sp_update_producto(?, ?, ?, ?, ?, ?, ?)', [
                $producto->id_producto,
                $validatedData['id_categoria'],
                $validatedData['nombre'],
                $validatedData['descripcion'] ?? null,
                $validatedData['precio'],
                $imagenPath,
                $validatedData['estado'],
            ]);

            return redirect()
                ->route('admin.productos')
                ->with('success', '✅ Producto actualizado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    /**
     * Elimina un producto y su imagen (si existe).
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminarProducto($id)
{
    try {
        $producto = Producto::findOrFail($id);

        // Eliminar imagen del almacenamiento
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // Llamar al SP
        DB::statement('CALL sp_delete_producto(?)', [$producto->id_producto]);

        return redirect()
            ->route('admin.productos')
            ->with('success', 'Producto eliminado correctamente.');

    } catch (\Illuminate\Database\QueryException $e) {

        // Si el SP lanzó SIGNAL SQLSTATE '45000'
        if ($e->getCode() == "45000") {
            return redirect()
                ->route('admin.productos')
                ->with('error', 'No se puede eliminar este producto porque está asociado a pedidos.');
        }

        // Si es error por FK (23000)
        if ($e->getCode() == "23000") {
            return redirect()
                ->route('admin.productos')
                ->with('error', 'No se puede eliminar porque tiene pedidos relacionados.');
        }

        return redirect()
            ->route('admin.productos')
            ->with('error', 'Error inesperado al intentar eliminar el producto.');
    }
}


    public function personalizados() {
        try {
            $personalizados = Personalizacion::with('usuario')
                ->orderBy('fecha_solicitud', 'desc')
                ->get();

            return view('admin.personalizados.lista-personalizados', compact('personalizados'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function detallesPersonalizado($id)
    {
        try {
            $personalizado = Personalizacion::with('usuario')
                ->findOrFail($id);

            return view('admin.personalizados.detalles-personalizado', compact('personalizado'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function actualizarEstadoPersonalizado(Request $request, $id)
    {
        try {
            $request->validate([
                'estado' => 'required|in:Pendiente,En Diseño,Aprobado,Rechazado,Entregado'
            ]);

            DB::statement('CALL sp_update_personalizacion_estado(?, ?)', [
                $id,
                $request->estado
            ]);

            return redirect()
                ->back()
                ->with('success', 'Estado actualizado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function actualizarCostoPersonalizado(Request $request, $id)
    {
        try {
            $request->validate([
                'costo_estimado' => 'required|numeric|min:1'
            ]);

            DB::statement('CALL sp_update_personalizacion_costo(?, ?)', [
                $id,
                $request->costo_estimado
            ]);

            return redirect()
                ->back()
                ->with('success', 'Costo estimado actualizado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function verPedidos(Request $request)
    {
        try {
            $estado = $request->get('estado');
            $pago   = $request->get('pago');

            $query = Pedido::with(['usuario', 'pago']);

            // Filtro por estado
            if ($estado && $estado !== 'Todos') {
                $query->where('estado', $estado);
            }

            // Filtro por mActodo de pago
            if ($pago && $pago !== 'Todos') {
                $query->whereHas('pago', function ($q) use ($pago) {
                    $q->where('metodo_pago', $pago);
                });
            }

            $pedidos = $query->orderBy('id_pedido', 'DESC')->get();

            return view('admin.pedidos.gestion-pedidos', compact('pedidos', 'estado', 'pago'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function detallesPedido($id)
    {
        try {
            $pedido = Pedido::with(['usuario', 'items'])->findOrFail($id);
            return view('admin.pedidos.detalles-pedido', compact('pedido'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function actualizarEstado(Request $request, $id)
    {
        try {
            $request->validate([
                'estado' => 'required|in:Pendiente,Preparación,Enviado,Entregado,Cancelado'
            ]);

            DB::statement('CALL sp_update_estado_pedido(?, ?)', [
                $id,
                $request->estado
            ]);

            return redirect()->back()->with('success', 'Estado actualizado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function categorias() {
        try {
            $categorias = Categoria::with([
                    'productos:id_producto,id_categoria,nombre'
                ])
                ->withCount('productos')
                ->orderBy('nombre')
                ->get();

            $totales = [
                'total' => $categorias->count(),
                'con_productos' => $categorias->where('productos_count', '>', 0)->count(),
                'productos_asociados' => $categorias->sum('productos_count'),
            ];

            return view('admin.categorias.categorias', compact('categorias', 'totales'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function crearCategoria()
    {
        try {
            return view('admin.categorias.crear');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function storeCategoria(Request $request)
    {
        try {
            $validated = $request->validate($this->categoriaRules());

            DB::select('CALL sp_insert_categoria(?)', [
                $validated['nombre']
            ]);

            return redirect()
                ->route('admin.categorias')
                ->with('success', 'Categoria creada correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function editarCategoria($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            return view('admin.categorias.editar', compact('categoria'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function updateCategoria(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id); // lectura

            $validated = $request->validate($this->categoriaRules($categoria));

            DB::statement('CALL sp_update_categoria(?, ?)', [
                $categoria->id_categoria,
                $validated['nombre'],
            ]);

            return redirect()
                ->route('admin.categorias')
                ->with('success', 'Categoria actualizada correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function eliminarCategoria($id)
    {
        try {
            $categoria = Categoria::withCount('productos')->findOrFail($id);

            if ($categoria->productos_count > 0) {
                return redirect()
                    ->route('admin.categorias')
                    ->with('error', 'No puedes eliminar una categoria con productos asociados.');
            }

            DB::statement('CALL sp_delete_categoria(?)', [$categoria->id_categoria]);

            return redirect()
                ->route('admin.categorias')
                ->with('success', 'Categoria eliminada correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function proveedores()
    {
        try {
            $proveedores = Proveedor::orderBy('nombre')->get();

            $totales = [
                'total' => $proveedores->count(),
                'activos' => $proveedores->where('estado', 'Activo')->count(),
            ];

            return view('admin.proveedores.proveedor', compact('proveedores', 'totales'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function crearProveedor()
    {
        try {
            return view('admin.proveedores.crear');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function storeProveedor(Request $request)
    {
        try {
            $validated = $request->validate($this->proveedorRules());

            DB::select('CALL sp_insert_proveedor(?, ?, ?, ?, ?, ?)', [
                $validated['nombre'],
                $validated['ruc'],
                $validated['correo'],
                $validated['telefono'],
                $validated['direccion'],
                $validated['estado'],
            ]);

            return redirect()
                ->route('admin.proveedores')
                ->with('success', 'Proveedor registrado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function editarProveedor($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);

            return view('admin.proveedores.editar', compact('proveedor'));
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function updateProveedor(Request $request, $id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id); // lectura

            $validated = $request->validate($this->proveedorRules($proveedor));

            DB::statement('CALL sp_update_proveedor(?, ?, ?, ?, ?, ?, ?)', [
                $proveedor->id_proveedor,
                $validated['nombre'],
                $validated['ruc'],
                $validated['correo'],
                $validated['telefono'],
                $validated['direccion'],
                $validated['estado'],
            ]);

            return redirect()
                ->route('admin.proveedores')
                ->with('success', 'Proveedor actualizado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    public function eliminarProveedor($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id); // lectura

            DB::statement('CALL sp_delete_proveedor(?)', [$proveedor->id_proveedor]);

            return redirect()
                ->route('admin.proveedores')
                ->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Throwable $e) {
            report($e);
            throw $e;
        }
    }

    private function categoriaRules(?Categoria $categoria = null): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
                Rule::unique('categorias', 'nombre')->ignore(
                    $categoria?->id_categoria,
                    'id_categoria'
                ),
            ],
        ];
    }

    private function proveedorRules(?Proveedor $proveedor = null): array
    {   
        return [
            'nombre' => ['required', 'string', 'max:120'],
            'ruc' => [
                'required',
                'digits:11',
                'regex:/^[0-9]+$/',
                Rule::unique('proveedores', 'ruc')->ignore(
                    $proveedor?->id_proveedor,
                    'id_proveedor'
                    ),
                ],

            'correo' => ['required', 'email', 'max:120'],

            'telefono' => [
            'required',
            'digits:9',
            'regex:/^[0-9]+$/',
            ],

            'direccion' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'in:Activo,Inactivo'],
        ];
    }

}
