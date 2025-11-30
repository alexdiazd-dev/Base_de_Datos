<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    // ← IMPORTANTE: agregar fecha_pedido aquí
    protected $fillable = [
        'id_usuario',
        'estado',
        'total',
        'fecha_pedido',
    ];

    // ← Permite que Laravel trate fecha_pedido como fecha real
    protected $dates = ['fecha_pedido'];

    // ← OPCIONAL PERO RECOMENDADO: ordenar siempre los pedidos más nuevos primero
    protected static function booted()
    {
        static::addGlobalScope('orden_fecha', function ($query) {
            $query->orderBy('fecha_pedido', 'DESC');
        });
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    public function pago()
    {
        return $this->hasOne(Pago::class, 'id_pedido', 'id_pedido');
    }

    public function envio()
    {
        return $this->hasOne(Envio::class, 'id_pedido', 'id_pedido');
    }
    public function codigo()
{
    return 'ORD-' . strtoupper(substr(sha1($this->id_pedido), 0, 6));
}

}
