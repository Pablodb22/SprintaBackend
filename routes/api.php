<?php

use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;


Route::post('/registro',[UsuariosController::class,'registro']); 

Route::post('/login',[UsuariosController::class,'login']);

Route::get('/usuario',[UsuariosController::class,'usuario']);

Route::put('/usuarioActualizado',[UsuariosController::class,'actualizarUsuario']);

Route::put('/usuarioNuevaPassword',[UsuariosController::class,'actualizarContraseña']);

Route::get('/funcionAdmin',[UsuariosController::class,'funcionAdmin']);

Route::get('/buscarTrabajadores',[UsuariosController::class,'buscarTrabajadores']);

Route::post('/crearProyectos',[ProyectosController::class,'crearProyecto']);

Route::get('/getProyectos',[ProyectosController::class,'getProyectos']);

Route::post('/crearTareas',[TareasController::class,'crearTareas']);

Route::get('/getTareasPorEmpresa', [TareasController::class, 'getTareasPorEmpresa']);