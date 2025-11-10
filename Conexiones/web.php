<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsuarioController;



use App\Models\ProductoModelo;
use App\Models\UsuarioModelo;
use App\Models\ServicioModelo;
use App\Models\ChatModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuario',[UsuarioController::class,"index"])->name("usuario.index");
Route::post('/usuario',[UsuarioController::class,"store"])->name("usuario.store");
Route::get('/usuario/{documento}/edit', [UsuarioController::class, 'edit'])->name('usuario.edit');
Route::put('/usuario/{documento}', [UsuarioController::class, 'update'])->name('usuario.update');
Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

Route::get('/Producto',[ProductoController::class,"index"])->name("producto");
Route::get('/Servicio',[ServicioController::class,"index"])->name("servicio");
Route::get('/Chat',[ChatController::class,"index"])->name("chat");
