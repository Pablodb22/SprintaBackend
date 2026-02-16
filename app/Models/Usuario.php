<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = true;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id', 
        'nombre',
        'email',
        'password',
        'tipo',
        'cod_empresa',
        'foto',
        'cargo',
        'ubicacion',
        'biografia'
    ];

    protected $hidden = [
        'password'
    ];
}