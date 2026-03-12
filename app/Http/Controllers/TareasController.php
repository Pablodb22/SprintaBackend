<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use App\Models\Proyectos;
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

    public function getTareasPorEmpresa(Request $request)
    {
        try {
            $empresaId = $request->query('empresa_id');
            
            if (!$empresaId) {
                return response()->json(['message' => 'empresa_id es requerido'], 400);
            }
            
            $proyectosIds = Proyectos::where('empresa', $empresaId)->pluck('id');

            if ($proyectosIds->isEmpty()) {
                return response()->json(['tareas' => []]);
            }
            
            $tareas = Tareas::whereIn('proyecto', $proyectosIds)->get();

            return response()->json(['tareas' => $tareas]);

        } catch (\Exception $e) {
            Log::error('Error al obtener tareas: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener tareas'], 500);
        }
    }

}