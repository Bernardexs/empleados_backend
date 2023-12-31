<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id_empleado',
        'entrada',
        'salida',
        'horas_trabajadas',
        'horas_extra',
    ];
}
