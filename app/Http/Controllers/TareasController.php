<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
use App\Models\Proyectos;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $tarea->acabada = false;
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
           
            $proyectos = Proyectos::where('empresa', $empresaId)->get()->keyBy('id');

            if ($proyectos->isEmpty()) {
                return response()->json(['tareas' => []]);
            }

            $tareas = Tareas::whereIn('proyecto', $proyectos->keys())->get();

            $tareasEnriquecidas = $tareas->map(function ($tarea) use ($proyectos) {
                $data = $tarea->toArray();
                
                $proyecto = $proyectos->get($tarea->proyecto);
                $data['proyecto_nombre'] = $proyecto ? $proyecto->nombre : null;
                
                $ids = [];
                if (!empty($tarea->trabajadores)) {
                    $decoded = json_decode($tarea->trabajadores, true);
                    $ids = is_array($decoded) ? $decoded : [];
                }
                
                if (!empty($ids)) {
                    $usuarios = Usuario::whereIn('id', $ids)
                        ->select('id', 'nombre', 'foto', 'cargo')
                        ->get();
                    $data['trabajadores_info'] = $usuarios->values();
                } else {
                    $data['trabajadores_info'] = [];
                }

                return $data;
            });

            return response()->json(['tareas' => $tareasEnriquecidas]);

        } catch (\Exception $e) {
            Log::error('Error al obtener tareas: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener tareas'], 500);
        }
    }

    public function acabarTarea(Request $request, string $id)
    {
        try {
            $tarea = Tareas::findOrFail($id);
            $tarea->acabada = true;
            $tarea->save();

            return response()->json(['message' => 'Tarea marcada como acabada', 'tarea' => $tarea]);
        } catch (\Exception $e) {
            Log::error('Error al acabar tarea: ' . $e->getMessage());
            return response()->json(['message' => 'Error al acabar tarea'], 500);
        }
    }
public function getTareasPorProyecto(Request $request)
{
    try {
        $proyectoId = $request->query('proyectoId');

        if (!$proyectoId) {
            return response()->json(['message' => 'proyectoId es requerido'], 400);
        }
        
        $tareas = Tareas::where('proyecto', $proyectoId)->get();
        
        $proyecto = Proyectos::find($proyectoId);

        $tareasEnriquecidas = $tareas->map(function ($tarea) use ($proyecto) {
            $data = $tarea->toArray();
            $data['proyecto_nombre'] = $proyecto ? $proyecto->nombre : null;

            $ids = [];
            if (!empty($tarea->trabajadores)) {
                $decoded = json_decode($tarea->trabajadores, true);
                $ids = is_array($decoded) ? $decoded : [];
            }

            if (!empty($ids)) {
                $usuarios = Usuario::whereIn('id', $ids)
                    ->select('id', 'nombre', 'foto', 'cargo')
                    ->get();
                $data['trabajadores_info'] = $usuarios->values();
            } else {
                $data['trabajadores_info'] = [];
            }

            return $data;
        });

        return response()->json(['tareas' => $tareasEnriquecidas]);

    } catch (\Exception $e) {
        Log::error('Error al obtener tareas: ' . $e->getMessage());
        return response()->json(['message' => 'Error al obtener tareas'], 500);
    }
}

}