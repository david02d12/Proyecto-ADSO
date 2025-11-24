<?php

namespace App\Http\Controllers;
use App\Models\PreguntaModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntaController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('pregunta');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Producto', 'LIKE', "%{$search}%")
                ->orwhere('ID_Usuario', 'LIKE', "%{$search}%")
                ->orwhere('Fecha', 'LIKE', "%{$search}%")
                ->orwhere('Pregunta', 'LIKE', "%{$search}%")
                ->orwhere('ID_Consulta','LIKE',"%{$search}%");
            
        });
        }
        $datos = $query->paginate(10);
        return view("pregunta")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Consulta' => 'required|unique:pregunta,ID_Consulta',
            'Codigo_Producto' => 'required|numeric',
            'ID_Usuario' => 'required|numeric',
            'Fecha' => 'required|numeric',
            'Pregunta' => 'required'
        ],[
            'ID_Consulta.unique' => 'La Pregunta con esta descripcion ya existe en la plataforma.',
        ]);

        PreguntaModelo::create($request->all());
        return redirect()->route('pregunta.index')->with('success','Pregunta Registrada en la Plataforma');
    }

    //Udate
    public function update(Request $request, $ID_Consulta){
        $request->validate([
            'ID_Consulta' => 'required|unique:pregunta,ID_Consulta,'. $ID_Consulta . ',ID_Consulta',
            'Codigo_Producto' => 'required|numeric',
            'Fecha' => 'required|numeric',
            'ID_COnsulta' => 'required|numeric',
            'Pregunta' => 'required'
        ],[
            'ID_Consulta.unique' => 'La Pregunta con esta descripcion ya existe en la plataforma.',
        ]);
        $producto = PreguntaModelo::findOrFail($ID_Consulta);
        $producto->update([
            'ID_Consulta' => $request->ID_Consulta,
            'Codigo_Producto' => $request->Codigo_Producto,
            'ID_Usuairo' => $request->ID_Usuario,
            'Pregunta' => $request->Pregunta,
            'Fecha' => $request->Fecha,
        ]);
           return redirect()->route('pregunta.index')->with('success','La Pregunta ha Actualizada en la Plataforma');

    }
    // Eliminar
public function destroy($id)
{
    $producto = PreguntaModelo::findOrFail($id);
    $producto->delete();

    return redirect()->route('pregunta.index')->with('success', 'La Pregunta ha sido eliminada correctamente');
}
}
