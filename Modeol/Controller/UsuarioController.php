<?php

namespace App\Http\Controllers;
use App\Models\UsuarioModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('usuario');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('ID_Usuario', 'LIKE', "%{$search}%")
                ->orwhere('Nombre', 'LIKE', "%{$search}%")
                ->orwhere('Correo','LIKE', "%{$search}");

            });
        }
        $datos = $query->paginate(10);
        return view("usuario")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Usuario' => 'required|unique:usuario,ID_Usuario',
            'Codigo_Documento' => 'required',
            'Nombre' => 'required',
            'Fecha_Nacimiento' => 'required',
            'Direccion' => 'required',
            'Telefono' => 'required|numeric',
            'Correo' => 'required|email',
            'Contraseña' => 'required',
            'Codigo_Rol' => 'required|numeric'
        ],[
            'ID_Usuario.unique' => 'El usuario con este documento ya existe en la plataforma.',
        ]);

        UsuarioModelo::create($request->all());
        return redirect()->route('usuario.index')->with('success','Usuario Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'ID_Usuario' => 'required|unique:usuario,ID_Usuario,'. $documento . ',ID_Usuario',
            'Codigo_Documento' => 'required',
            'Nombre' => 'required',
            'Fecha_Nacimiento' => 'required',
            'Direccion' => 'required',
            'Telefono' => 'required|numeric',
            'Correo' => 'required|email',
            'Contraseña' => 'required',
            'Codigo_Rol' => 'required|numeric'
        ],[
            'ID_Usuario.unique' => 'El usuario con este documento ya existe en la plataforma.',
        ]);
        $usuario = UsuarioModelo::findOrFail($documento);
        $usuario->update([
             'ID_Usuario' => $request->ID_Usuario,
             'Codigo_Documento' => $request->Codigo_Documento,
            'Nombre' => $request->Nombre,
            'Fecha_Nacimiento' => $request->Fecha_Nacimiento,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'Correo' => $request->Correo,
            'Contraseña' => $request->Contraseña,
            'Codigo_Rol' => $request->Codigo_Rol,
        ]);
           return redirect()->route('usuario.index')->with('success','Usuario Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($id)
{
    $usuario = UsuarioModelo::findOrFail($id);
    $usuario->delete();

    return redirect()->route('usuario.index')->with('success', 'Usuario eliminado correctamente');
}
}
