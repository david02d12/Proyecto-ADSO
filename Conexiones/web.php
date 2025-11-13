<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsuarioController;



use App\Models\CategoriaModelo;
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

Route::get('/servicio',[ServicioController::class,"index"])->name("servicio.index");
Route::post('/servicio',[ServicioController::class,"store"])->name("servicio.store");
Route::get('/servicio/{documento}/edit', [ServicioController::class, 'edit'])->name('servicio.edit');
Route::put('/servicio/{documento}', [ServicioController::class, 'update'])->name('servicio.update');
Route::delete('/servicio/{id}', [ServicioController::class, 'destroy'])->name('servicio.destroy');

Route::get('/categoria',[CategoriaController::class,"index"])->name("categoria.index");
Route::post('/categoria',[CategoriaController::class,"store"])->name("categoria.store");
Route::get('/categoria/{documento}/edit', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::put('/categoria/{documento}', [CategoriaController::class, 'update'])->name('categoria.update');
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');

Route::get('/chat',[ChatController::class,"index"])->name("chat.index");
Route::post('/chat',[ChatController::class,"store"])->name("chat.store");
Route::get('/chat/{documento}/edit', [ChatController::class, 'edit'])->name('chat.edit');
Route::put('/chat/{documento}', [ChatController::class, 'update'])->name('chat.update');
Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
