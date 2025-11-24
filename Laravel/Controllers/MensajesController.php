<?php

namespace App\Http\Controllers;
use App\Models\MensajesModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MensajesController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('mensajes');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Mensaje', 'LIKE', "%{$search}%")
                ->orwhere('Codigo_Chat', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("mensajes")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Mensaje' => 'required|unique:mensajes,Codigo_Mensaje',
            'Codigo_Chat' => 'required',
            'ID_Usuario' => 'required',
            'Fecha_Mensaje' => 'required',
            'Mensaje' => 'required',
            'Estado' => 'required'
        ],[
            'Codigo_Mensaje.unique' => 'El mensaje con este codigo ya existe en la plataforma.',
        ]);

        MensajesModelo::create($request->all());
        return redirect()->route('mensajes.index')->with('success','Mensaje Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'Codigo_Mensaje' => 'required|unique:mensajes,Codigo_Mensaje,'. $documento . ',Codigo_Mensaje',
            'Codigo_Chat' => 'required',
            'ID_Usuario' => 'required',
            'Fecha_Mensaje' => 'required',
            'Mensaje' => 'required',
            'Estado' => 'required'
        ],[
            'Codigo_Mensaje.unique' => 'El mensaje con este codigo ya existe en la plataforma.',
        ]);
        $mensajes_servicios = MensajesModelo::findOrFail($documento);
        $mensajes_servicios->update([
            'Codigo_Mensaje' => $request->Codigo_Mensaje,
            'Codigo_Chat' => $request->Codigo_Chat,
            'ID_Usuario' => $request->ID_Usuario,
            'Fecha_Mensaje' => $request->Fecha_Mensaje,
            'Mensaje' => $request->Mensaje,
            'Estado' => $request->Estado,

        ]);
           return redirect()->route('Codigo_Mensaje.index')->with('success','Mensaje Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $mensajes = MensajesModelo::findOrFail($idocumento);
    $mensajes->delete();

    return redirect()->route('Codigo_Mensaje.index')->with('success', 'Mensaje eliminado correctamente');
}
}
