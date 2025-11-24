<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\MensajesController;



use App\Models\CategoriaModelo;
use App\Models\UsuarioModelo;
use App\Models\ServicioModelo;
use App\Models\ChatModelo;
use App\Models\HistorialModelo;
use App\Models\ProductoModelo;
use App\Models\ComentarioModelo;
use App\Models\NotificacionesModelo;
use App\Models\PreguntaModelo;
use App\Models\RolesModelo;
use App\Models\TipoModelo;
use App\Models\MensajesModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function(){return view('index');})->name("index");

Route::get('/protochat', function(){return view('protochat');})->name("protochat");

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

Route::get('/historial',[HistorialController::class,"index"])->name("historial.index");
Route::post('/historial',[HistorialController::class,"store"])->name("historial.store");
Route::get('/historial/{documento}/edit', [HistorialController::class, 'edit'])->name('historial.edit');
Route::put('/historial/{documento}', [HistorialController::class, 'update'])->name('historial.update');
Route::delete('/historial/{id}', [HistorialController::class, 'destroy'])->name('historial.destroy');

Route::get('/producto',[ProductoController::class,"index"])->name("producto.index");
Route::post('/producto',[ProductoController::class,"store"])->name("producto.store");
Route::get('/producto/{documento}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
Route::put('/producto/{documento}', [ProductoController::class, 'update'])->name('producto.update');
Route::delete('/producto/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');

Route::get('/comentarios',[ComentarioController::class,"index"])->name("comentarios.index");
Route::post('/comentarios',[ComentarioController::class,"store"])->name("comentarios.store");
Route::get('/comentarios/{documento}/edit', [ComentarioController::class, 'edit'])->name('comentarios.edit');
Route::put('/comentarios/{documento}', [ComentarioController::class, 'update'])->name('comentarios.update');
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

Route::get('/notificaciones',[NotificacionesController::class,"index"])->name("notificaciones.index");
Route::post('/notificaciones',[NotificacionesController::class,"store"])->name("notificaciones.store");
Route::get('/notificaciones/{documento}/edit', [NotificacionesController::class, 'edit'])->name('notificaciones.edit');
Route::put('/notificaciones/{documento}', [NotificacionesController::class, 'update'])->name('notificaciones.update');
Route::delete('/notificaciones/{id}', [NotificacionesController::class, 'destroy'])->name('notificaciones.destroy');

Route::get('/pregunta',[PreguntaController::class,"index"])->name("pregunta.index");
Route::post('/pregunta',[PreguntaController::class,"store"])->name("pregunta.store");
Route::get('/pregunta/{documento}/edit', [PreguntaController::class, 'edit'])->name('pregunta.edit');
Route::put('/pregunta/{documento}', [PreguntaController::class, 'update'])->name('pregunta.update');
Route::delete('/pregunta/{id}', [PreguntaController::class, 'destroy'])->name('pregunta.destroy');

Route::get('/roles',[RolesController::class,"index"])->name("roles.index");
Route::post('/roles',[RolesController::class,"store"])->name("roles.store");
Route::get('/roles/{documento}/edit', [RolesController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{documento}', [RolesController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');

Route::get('/tipo',[TipoController::class,"index"])->name("tipo.index");
Route::post('/tipo',[TipoController::class,"store"])->name("tipo.store");
Route::get('/tipo/{documento}/edit', [TipoController::class, 'edit'])->name('tipo.edit');
Route::put('/tipo/{documento}', [TipoController::class, 'update'])->name('tipo.update');
Route::delete('/tipo/{id}', [TipoController::class, 'destroy'])->name('tipo.destroy');

Route::get('/mensajes',[MensajesController::class,"index"])->name("mensajes.index");
Route::post('/mensajes',[MensajesController::class,"store"])->name("mensajes.store");
Route::get('/mensajes/{documento}/edit', [MensajesController::class, 'edit'])->name('mensajes.edit');
Route::put('/mensajes/{documento}', [MensajesController::class, 'update'])->name('mensajes.update');
Route::delete('/mensajes/{id}', [MensajesController::class, 'destroy'])->name('mensajes.destroy');