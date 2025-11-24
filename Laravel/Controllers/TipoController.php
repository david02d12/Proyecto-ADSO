<?php

namespace App\Http\Controllers;
use App\Models\TipoModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('tipo_documento');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Documento', 'LIKE', "%{$search}%")
                ->orwhere('Nombre_Documento', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("tipo")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Documento' => 'required|unique:tipo_documento,Codigo_Documento',
            'Nombre_Documento' => 'required'
        ],[
            'Codigo_Documento.unique' => 'El tipo de documento con este codigo ya existe en la plataforma.',
        ]);

    TipoModelo::create($request->all());
        return redirect()->route('tipo.index')->with('success','Tipo de documento Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'Codigo_Documento' => 'required|unique:tipo_documento,Codigo_Documento,'. $documento . ',Codigo_Documento',
            'Nombre_Documento' => 'required'
        ],[
            'Codigo_Documento.unique' => 'El tipo de documento con este codigo ya existe en la plataforma.',
        ]);
        $roles = TipoModelo::findOrFail($documento);
        $roles->update([
             'Codigo_Documento' => $request->Codigo_Documento,
             'Nombre_Documento' => $request->Nombre_Documento,
        ]);
           return redirect()->route('tipo.index')->with('success','Tipo de Documento Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $tipo = TipoModelo::findOrFail($idocumento);
    $tipo->delete();

    return redirect()->route('tipo.index')->with('success', 'Tipo de Documento eliminado correctamente');
}
}
