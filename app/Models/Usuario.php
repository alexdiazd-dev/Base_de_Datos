<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_rol',
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'telefono',
        'fecha_registro'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }

    public function personalizaciones()
    {
        return $this->hasMany(Personalizacion::class, 'id_usuario', 'id_usuario');
    }
}
