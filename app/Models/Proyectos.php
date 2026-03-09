<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    
    public $timestamps = false; 

    protected $fillable = [
        'id', 
        'nombre',
        'tipo',
        'descripcion',
        'trabajadores',
        'tareas',
        'empresa'
    ];
}