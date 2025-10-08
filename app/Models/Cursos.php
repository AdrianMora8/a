<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    protected $filltable = [
        'nombre',
        'descripcion',
        'cedula_alumno',
    ];

    public function alumno(){
        return $this->belongsTo(Alumnos::class, 'cedula_alumno', 'cedula');
    }
}
