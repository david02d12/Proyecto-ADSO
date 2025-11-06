<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;



use App\Models\UsuariosModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Usuarios',[UsuariosController::class,"index"])->name("usuarios");