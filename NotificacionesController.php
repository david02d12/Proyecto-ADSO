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
                ->orwhere('Tipo_NOtificacion', 'LIKE', "%{$search}%");

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
            'Tipo_Notificacion.unique' => 'La Notificacion de este tipo ya existe en la plataforma.',
        ]);

        NotificacionesModelo::create($request->all());
        return redirect()->route('notificaciones.index')->with('success','Notificacion Registrada en la Plataforma');
    }

    //Udate
    public function update(Request $request, $Codigo_Notificaciones){
        $request->validate([
            'notificaciones' => 'required|unique:notificaciones,notificaciones,'. $Codigo_Notificaciones . ',notificaciones',
            
        ],[
            'Codigo_Notificacion.unique' => 'La notificacion de este tipo ya existe en la plataforma.',
        ]);
        $Comentario = NotificacionesModelo::findOrFail($Codigo_Notificaciones);
        $Comentario->update([
            'Codigo_Notificaciones' => $request->Codigo_Notificaciones,
            'Tipo_Notificacion' => $request->Tipo_Notificacion,
            
        ]);
           return redirect()->route('notificaciones.index')->with('success','Notificacion Actualizada en la Plataforma');

    }
    // Eliminar
public function destroy($id)
{
    $Comentario = NotificacionesModelo::findOrFail($id);
    $Comentario->delete();

    return redirect()->route('notificacion.index')->with('success', 'Notificacion eliminada correctamente');
}
}
