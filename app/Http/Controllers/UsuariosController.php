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
            
                      
                        
            $usuario = Usuario::create([
                'id' => Str::uuid()->toString(), 
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
        try {
            $usuario = Usuario::where('email', $request->email)->first();

            if (!$usuario || !Hash::check($request->password, $usuario->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'data' => $usuario
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error al iniciar sesión:', [
                'message' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}