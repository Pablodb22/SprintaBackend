<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
    public function registro(Request $request)
    {
        try {
            Log::info('Datos recibidos:', $request->all());
            
            $validated = $request->validate([
                'fullname' => 'required|string',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:8',
                'tipo' => 'required|string|in:Individual,Empresa',
            ]);
            
            Log::info('Validación pasada');
            
            // Crear usuario con UUID explícito
            $usuario = Usuario::create([
                'id' => Str::uuid()->toString(), // Generar UUID explícitamente
                'nombre' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tipo' => $request->tipo,
            ]);
            
            Log::info('Usuario creado exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'data' => $usuario
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error general:', [
                'message' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function login(Request $request)
    {
        return response()->json([
            'message' => 'Login recibido',
            'data' => $request->all()
        ]);
    }
}