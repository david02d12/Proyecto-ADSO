<?php

namespace App\Http\Controllers;
use App\Models\ComentarioModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentarioController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('comentario');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('codigo_Comentario', 'LIKE', "%{$search}%")
                ->orwhere('comentario', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("comentario")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Comentario' => 'required|unique:Comentario,ID_Comentario',
            'ID_Usuario' => 'required',
            'Comentario' => 'required',
            'Fecha_Comentario' => 'required|date',
        ],[
            'ID_Comentario.unique' => 'El Comentario con este ID ya existe en la plataforma.',
        ]);

        ComentarioModelo::create($request->all());
        return redirect()->route('comentario.index')->with('success','Comentario Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $Codigo_Comentario){
        $request->validate([
            'Comentario' => 'required|unique:Comentario,Comentario,'. $Codigo_Comentario . ',Comentario',
            
        ],[
            'ID_Comentario.unique' => 'El Comentario con este ID ya existe en la plataforma.',
        ]);
        $Comentario = ComentarioModelo::findOrFail($Codigo_Comentario);
        $Comentario->update([
            'ID_Comentario' => $request->ID_Comentario,
            'ID_Usuario' => $request->ID_Usuario,
            'Comentario' => $request->Comentario,
            'Fecha_Comentario' => $request->Fecha_comentario,
           
        ]);
           return redirect()->route('Comentario.index')->with('success','Comentario Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($id)
{
    $Comentario = ComentarioModelo::findOrFail($id);
    $Comentario->delete();

    return redirect()->route('Comentario.index')->with('success', 'Comentario eliminado correctamente');
}
}
