<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    protected  $filltable =[
        'cedula',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
    ];

    public function cursos(){
        return $this->hasMany(Cursos::class, 'cedula_alumno', 'cedula');
    }
}
