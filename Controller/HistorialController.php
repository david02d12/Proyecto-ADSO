<?php

namespace App\Http\Controllers;
use App\Models\HistorialModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('historial_servicios');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('ID_Historial', 'LIKE', "%{$search}%")
                ->orwhere('Fecha_Evento', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("historial")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Historial' => 'required|unique:historial_servicios,ID_Historial',
            'ID_Servicio' => 'required',
            'Fecha_Evento' => 'required',
            'Descripcion_Evento' => 'required',
            'Estado' => 'required'
        ],[
            'ID_Historial.unique' => 'El Historial con este codigo ya existe en la plataforma.',
        ]);

        HistorialModelo::create($request->all());
        return redirect()->route('historial.index')->with('success','Historial Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'ID_Historial' => 'required|unique:historial_servicios,ID_Historial,'. $documento . ',ID_Historial',
            'ID_Servicio' => 'required',
            'Fecha_Evento' => 'required',
            'Descripcion_Evento' => 'required',
            'Estado' => 'required'
        ],[
            'ID_Historial.unique' => 'El historial con este codigo ya existe en la plataforma.',
        ]);
        $historial_servicios = HistorialModelo::findOrFail($documento);
        $historial_servicios->update([
             'ID_Hisorial' => $request->ID_Historial,
             'ID_Servicio' => $request->ID_Servicio,
             'Fecha_Evento' => $request->Fecha_Evento,
            'Descripcion_Evento' => $request->Descrpcion_Evento,
            'Estado' => $request->Estado,

        ]);
           return redirect()->route('historial_servicios.index')->with('success','Historial Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $historial_servicios = HistorialModelo::findOrFail($idocumento);
    $historial_servicios->delete();

    return redirect()->route('historial_servicios.index')->with('success', 'Historial eliminado correctamente');
}
}
