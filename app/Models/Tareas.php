<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{   

    protected $table = 'tareas';
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = true;
    
    const CREATED_AT = 'created_at';    

    protected $fillable = [
        'id', 
        'nombre',
        'descripcion',
        'prioridad',
        'trabajadores',
        'proyecto',
    ];


}