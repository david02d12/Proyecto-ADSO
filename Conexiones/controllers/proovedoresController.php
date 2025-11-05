<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Usar DB::table() para poder paginar
        $query = DB::table('cliente');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombreCliente', 'LIKE', "%{$search}%")
                  ->orWhere('apellidoCliente', 'LIKE', "%{$search}%")
                  ->orWhere('documentoCliente', 'LIKE', "%{$search}%");
            });
        }
        
        // Paginar los resultados (10 por página)
        $datos = $query->paginate(10);
        
        return view("cliente")->with("datos", $datos);
    }

}
/*use HasFactory;
    protected $table = 'cliente';

    protected $fillable=[
        'documentoCliente',
        'tipoDocumentoCliente', 
        'nombreCliente',
        'apellidoCliente',
        'direccionCliente',
        'telefonoCliente',
        'emailCliente'

    ];
     public $timestamps = false;*/