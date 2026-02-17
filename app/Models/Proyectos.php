<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{   

    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = true;
    
    const CREATED_AT = 'created_at';

    protected $fillable = [
        'id', 
        'nombre',
        'tipo',
        'trabajadores',
        'tareas'
    ];

}