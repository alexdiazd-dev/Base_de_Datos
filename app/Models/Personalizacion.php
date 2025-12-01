<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalizacion extends Model
{
    use HasFactory;

    protected $table = 'personalizaciones';
    protected $primaryKey = 'id_personalizacion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_solicitud',
        'descripcion',
        'tamano',
        'sabor',
        'ocasion',
        'imagen_referencia',
        'imagen_ia',
        'notas_adicionales',
        'costo_estimado',
        'estado'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
