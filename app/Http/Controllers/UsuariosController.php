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

    public function usuario(Request $request){
        try{            
            $email = request()->query('email');

            Log::info("Email recibido: " . $email);

            $usuario = Usuario::where('email', $email)->first();
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Usuario encontrado',
                'data' => $usuario
            ], 200);            

        }catch(\Exception $e){
            Log::error('Error al obtener usuarios:', [
                'message' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   public function actualizarUsuario(Request $request){
        
    try{
        $email = request()->query('email');
        $usuario = Usuario::where('email', $email)->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        
        if ($request->cod_empresa) {
            $empresa = Usuario::where('id', $request->cod_empresa)                              
                              ->first();

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código de empresa no es válido'
                ], 422);
            }
        }

        $usuario->nombre    = $request->nombre;         
        $usuario->foto      = $request->foto;
        $usuario->cargo     = $request->cargo;
        $usuario->ubicacion = $request->ubicacion;
        $usuario->biografia = $request->biografia;
        $usuario->cod_empresa = $request->cod_empresa;

        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $usuario
        ], 200);

    }catch(\Exception $e){
        Log::error('Error al actualizar usuario:', [
            'message' => $e->getMessage(),
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar usuario',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function actualizarContraseña(Request $request){
        
    try{

            $email = request()->query('email');
            $usuario = Usuario::where('email', $email)->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            if (!Hash::check($request->actual, $usuario->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contraseña actual incorrecta'
                ], 401);
            }

            if ($request->nueva !== $request->confirmar) {
                return response()->json([
                    'success' => false,
                    'message' => 'La nueva contraseña y la confirmación no coinciden'
                ], 400);
            }
    
            $usuario->password = Hash::make($request->nueva);
    
            $usuario->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente',
                'data' => $usuario
            ], 200);
    }catch(\Exception $e){
        Log::error('Error al actualizar contraseña:', [
            'message' => $e->getMessage(),
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar contraseña',
            'error' => $e->getMessage()
        ], 500);

    }

    }

    public function funcionAdmin(Request $request){
        try{
            $email = request()->query('email');
            $usuario = Usuario::where('email', $email)->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado funcion admin'
                ], 404);
            }

            if ($usuario->tipo === 'Empresa') {
                return response()->json([
                    'success' => true,
                    'message' => 'Acceso concedido a función de administrador',
                    'data' => $usuario
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Acceso denegado. Usuario no es administrador.'
                ], 403);
            }
        }catch(\Exception $e){
            Log::error('Error en función admin:', [
                'message' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error en función admin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function buscarTrabajadores(Request $request){
        try{
            $email = request()->query('email');
            $usuario = Usuario::where('email', $email)->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado función buscar trabajadores'
                ], 404);
            }

            if ($usuario->tipo === 'Empresa') {
                $trabajadores = Usuario::where('cod_empresa', $usuario->id)->get();

                $data=[];

                foreach($trabajadores as $trabajador){
                    $data[]=[
                        'id' => $trabajador->id,
                        'nombre' => $trabajador->nombre,                        
                        'foto' => $trabajador->foto
                    ];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Trabajadores encontrados',
                    'data' => $data
                ], 200);
            } else {
                $trabajadores = Usuario::where('cod_empresa', $usuario->cod_empresa)->get();

                $data=[];

                foreach($trabajadores as $trabajador){
                    $data[]=[
                        'id' => $trabajador->id,
                        'nombre' => $trabajador->nombre,                        
                        'foto' => $trabajador->foto
                    ];
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Trabajadores encontrados',
                    'data' => $data
                ], 200);
            }
        }catch(\Exception $e){
            Log::error('Error en función buscar trabajadores:', [
                'message' => $e->getMessage(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error en función buscar trabajadores',
                'error' => $e->getMessage()
            ], 500);
        }

    }

}