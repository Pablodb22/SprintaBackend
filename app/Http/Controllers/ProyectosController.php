<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProyectosController extends Controller
{
   

    public function crearProyecto(Request $request)
    {
        try {
            $proyecto = new Proyectos();
            $proyecto->nombre = $request->input('nombre');
            $proyecto->tipo = $request->input('tipo'); 
            $proyecto->save();

            return response()->json(['message' => 'Proyecto creado exitosamente', 'proyecto' => $proyecto], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear proyecto: ' . $e->getMessage());
            return response()->json(['message' => 'Error al crear proyecto'], 500);
        }
    }
}