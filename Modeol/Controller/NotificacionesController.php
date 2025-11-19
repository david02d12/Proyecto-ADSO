<?php

namespace App\Http\Controllers;
use App\Models\NotificacionesModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificacionesController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('notificaciones');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Notificaciones', 'LIKE', "%{$search}%")
                // Se corrigió a 'Tipo_Notificacion' con mayúscula
                ->orwhere('Tipo_Notificacion', 'LIKE', "%{$search}%"); 
            });
        }
        $datos = $query->paginate(10);
        return view("notificaciones")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Notificaciones' => 'required|unique:notificaciones,Codigo_Notificaciones',
            'Tipo_Notificacion' => 'required',
        ],[
            // Corregida la clave de mensaje de error
            'Codigo_Notificaciones.unique' => 'El código de notificación ya existe.',
            'Tipo_Notificacion.required' => 'El tipo de notificación es obligatorio.',
        ]);

        NotificacionesModelo::create($request->all());
        return redirect()->route('notificaciones.index')->with('success','Notificación Registrada en la Plataforma');
    }

    // Update
    public function update(Request $request, $Codigo_Notificaciones){
        $request->validate([
            // La validación debe ser contra el campo 'Tipo_Notificacion'
            'Tipo_Notificacion' => 'required|unique:notificaciones,Tipo_Notificacion,' . $Codigo_Notificaciones . ',Codigo_Notificaciones',
            
        ],[
            'Tipo_Notificacion.unique' => 'La Notificación de este tipo ya existe en la plataforma.',
        ]);
        
        $notificacion = NotificacionesModelo::findOrFail($Codigo_Notificaciones);
        $notificacion->update([
            // No se debe actualizar la clave primaria (Codigo_Notificaciones)
            'Tipo_Notificacion' => $request->Tipo_Notificacion,
            
        ]);
        return redirect()->route('notificaciones.index')->with('success','Notificación Actualizada en la Plataforma');

    }
    // Eliminar
    public function destroy($id)
    {
        $notificacion = NotificacionesModelo::findOrFail($id);
        $notificacion->delete();

        // Corregida la ruta de redirección a 'notificaciones.index'
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente');
    }
}