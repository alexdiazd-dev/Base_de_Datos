<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'estado'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto', 'id_producto');
    }
}
