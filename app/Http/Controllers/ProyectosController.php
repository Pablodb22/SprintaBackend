<?php

namespace App\Http\Controllers;

use App\Models\Tareas;
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
        $proyecto->descripcion = $request->input('descripcion'); 
        $proyecto->empresa= $request->input('empresa');
        $proyecto->save();

        return response()->json(['message' => 'Proyecto creado exitosamente', 'proyecto' => $proyecto], 201);
    } catch (\Exception $e) {
        Log::error('Error al crear proyecto: ' . $e->getMessage());
        return response()->json(['message' => 'Error al crear proyecto'], 500);
    }
}

public function getProyectos(Request $request)
{
    try {
        $empresa = $request->query('empresa');
        
        if (!$empresa) {
            return response()->json(['message' => 'Código de empresa requerido'], 400);
        }

        $proyectos = Proyectos::where('empresa', $empresa)->get();

        return response()->json([
            'success' => true,
            'data' => $proyectos
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error al obtener proyectos: ' . $e->getMessage());
        return response()->json(['message' => 'Error al obtener proyectos'], 500);
    }
}


public function eliminarProyecto(string $id)
{
    try {
        $proyecto = Proyectos::findOrFail($id);

        Tareas::where('proyecto', $id)->delete();
        
        $proyecto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proyecto y sus tareas eliminados correctamente'
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error al eliminar proyecto: ' . $e->getMessage());
        return response()->json(['message' => 'Error al eliminar proyecto'], 500);
    }
}

}

