<?php

namespace App\Http\Controllers;
use App\Models\CategoriaModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('categoria');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('ID_Categoria', 'LIKE', "%{$search}%")
                ->orwhere('Nombre_Categoria', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("categoria")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Categoria' => 'required|unique:categoria,ID_Categoria',
            'Nombre_Categoria' => 'required'
        ],[
            'ID_Categoria.unique' => 'La categoria con este codigo ya existe en la plataforma.',
        ]);

        CategoriaModelo::create($request->all());
        return redirect()->route('categoria.index')->with('success','Categoria Registrada en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'ID_Categoria' => 'required|unique:categoria,ID_Categoria,'. $documento . ',ID_Categoria',
            'Nombre_Categoria' => 'required'
        ],[
            'ID_Categoria.unique' => 'La categoria con este codigo ya existe en la plataforma.',
        ]);
        $categoria = CategoriaModelo::findOrFail($documento);
        $categoria->update([
             'ID_Categoria' => $request->ID_Categoria,
             'Nombre_Categoria' => $request->Nombre_Categoria,
        ]);
           return redirect()->route('categoria.index')->with('success','Categoria Actualizada en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $categoria = CategoriaModelo::findOrFail($idocumento);
    $categoria->delete();

    return redirect()->route('categoria.index')->with('success', 'Categoria eliminada correctamente');
}
}
