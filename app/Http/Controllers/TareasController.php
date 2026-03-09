<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TareasController extends Controller
{
 
    public function crearTareas(Request $request)
    {
        try {
            $tarea = new Tareas();
            $tarea->nombre = $request->input('nombre');
            $tarea->descripcion = $request->input('descripcion');
            $tarea->prioridad = $request->input('prioridad');
            $tarea->proyecto = $request->input('proyecto');
            $tarea->trabajadores = json_encode($request->input('trabajadores', []));
            $tarea->save();

            return response()->json(['message' => 'Tarea creada exitosamente', 'tarea' => $tarea], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear tarea: ' . $e->getMessage());
            return response()->json(['message' => 'Error al crear tarea'], 500);
        }
    }

}