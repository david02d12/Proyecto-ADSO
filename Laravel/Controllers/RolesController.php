<?php

namespace App\Http\Controllers;
use App\Models\RolesModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('roles');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Rol', 'LIKE', "%{$search}%")
                ->orwhere('Descripcion_Rol', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("roles")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Rol' => 'required|unique:roles,Codigo_Rol',
            'Descripcion_Rol' => 'required'
        ],[
            'Codigo_Rol.unique' => 'El rol con este codigo ya existe en la plataforma.',
        ]);

    RolesModelo::create($request->all());
        return redirect()->route('roles.index')->with('success','Rol Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'Codigo_Rol' => 'required|unique:roles,Codigo_Rol,'. $documento . ',Codigo_Rol',
            'Descripcion_Rol' => 'required'
        ],[
            'Codigo_Rol.unique' => 'El rol con este codigo ya existe en la plataforma.',
        ]);
        $roles = RolesModelo::findOrFail($documento);
        $roles->update([
             'Codigo_Rol' => $request->Codigo_Rol,
             'Descripcion_Rol' => $request->Descripcion_Rol,
        ]);
           return redirect()->route('roles.index')->with('success','Rol Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $roles = RolesModelo::findOrFail($idocumento);
    $roles->delete();

    return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
}
}
