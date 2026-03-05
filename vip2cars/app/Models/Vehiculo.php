<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'anio_fabricacion',
        'nombre_cliente',
        'apellidos_cliente',
        'nro_documento',
        'correo_cliente',
        'telefono_cliente',
    ];
}