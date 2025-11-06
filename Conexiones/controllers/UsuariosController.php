<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Models\UsuariosModelo;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = UsuariosModelo::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ID_Usuario', 'LIKE', "%{$search}%")
                  ->orWhere('Codigo_Documento', 'LIKE', "%{$search}%")
                  ->orWhere('Nombre', 'LIKE', "%{$search}%")
                  ->orWhere('Fecha_Nacimiento', 'LIKE', "%{$search}%")
                  ->orWhere('Direccion', 'LIKE', "%{$search}%")
                  ->orWhere('Telefono', 'LIKE', "%{$search}%")
                  ->orWhere('Correo', 'LIKE', "%{$search}%")
                  ->orWhere('Contraseña', 'LIKE', "%{$search}%")
                  ->orWhere('Codigo_Rol', 'LIKE', "%{$search}%");
            });
        }
        $datos = $query->paginate(10);
        return view('usuarios', compact('datos'));



    }
}
