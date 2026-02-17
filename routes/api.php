<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;


Route::post('/registro',[UsuariosController::class,'registro']); 

Route::post('/login',[UsuariosController::class,'login']);

Route::get('/usuario',[UsuariosController::class,'usuario']);