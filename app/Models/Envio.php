<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = 'envios';
    protected $primaryKey = 'id_envio';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'direccion',
        'ciudad',
        'metodo_pago',
        'costo_envio',
        'notas',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
