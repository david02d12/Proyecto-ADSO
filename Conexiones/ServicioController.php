<?php

namespace App\Http\Controllers;
use App\Models\ServicioModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('servicio');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('ID_Servicio', 'LIKE', "%{$search}%")
                ->orwhere('Movil_Nombre', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("servicio")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'ID_Servicio' => 'required|unique:servicio,ID_servicio',
            'Descripcion' => 'required',
            'ID_Usuario' => 'required',
            'Precio' => 'required',
            'Movil_Nombre' => 'required',
            'Movil_Especificacion' => 'required|numeric',
            'Fecha' => 'required|email',
            'Etapa' => 'required'
        ],[
            'ID_Servicio.unique' => 'El servicio con este codigo ya existe en la plataforma.',
        ]);

        servicioModelo::create($request->all());
        return redirect()->route('servicio.index')->with('success','Servicio Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'ID_Servicio' => 'required|unique:servicio,ID_Servicio,'. $documento . ',ID_Servicio',
            'Descripcion' => 'required',
            'ID_Usuario' => 'required',
            'Precio' => 'required',
            'Movil_Nombre' => 'required',
            'Movil_Especificacion' => 'required|numeric',
            'Fecha' => 'required|email',
            'Etapa' => 'required'
        ],[
            'ID_Servicio.unique' => 'El servicio con este codigo ya existe en la plataforma.',
        ]);
        $servicio = ServicioModelo::findOrFail($documento);
        $servicio->update([
            'ID_Servicio' => $request->ID_Servicio,
            'Descripcion' => $request->Descripcion,
            'ID_Usuario' => $request->ID_Usuario,
            'Precio' => $request->Precio,
            'Movil_Nombre' => $request->Movil_Nombre,
            'Movil_Especificacion' => $request->Movil_Especificacion,
            'Fecha' => $request->Fecha,
            'Etapa' => $request->Etapa,
        ]);
           return redirect()->route('servicio.index')->with('success','Servicio Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $servicio = ServicioModelo::findOrFail($idocumento);
    $servicio->delete();

    return redirect()->route('servicio.index')->with('success', 'Servicio eliminado correctamente');
}
}
