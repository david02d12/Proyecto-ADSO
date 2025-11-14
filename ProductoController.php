<?php

namespace App\Http\Controllers;
use App\Models\ProductoModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('producto');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Producto', 'LIKE', "%{$search}%")
                ->orwhere('Nombre', 'LIKE', "%{$search}%")
                ->orwhere('Descripcion','LIKE',"%{$search}%");
            
        });
        }
        $datos = $query->paginate(10);
        return view("producto")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Producto' => 'required|unique:producto,Codigo_Producto',
            'Cantidad' => 'required|numeric',
            'Nombre' => 'required',
            'Precio' => 'required|numeric',
            'Descripcion' => 'required',
            'Imagen' => 'required',
            'Activo_Catalogo' => 'required',
            'ID_Categoria' => 'required'
        ],[
            'Codigo_Producto.unique' => 'El Producto con esta descripcion ya existe en la plataforma.',
        ]);

        ProductoModelo::create($request->all());
        return redirect()->route('producto.index')->with('success','Producto Registrado en la Plataforma');
    }

    //Udate
    public function update(Request $request, $ID_Categoria){
        $request->validate([
            'Codigo_Producto' => 'required|unique:producto,Codigo_Producto,'. $ID_Categoria . ',Codigo_Producto',
            'Cantidad' => 'required|numeric',
            'Nombre' => 'required',
            'Precio' => 'required|numeric',
            'Descripcion' => 'required',
            'Imagen' => 'required',
            'Activo_Catalogo' => 'required',
            'ID_Categoria' => 'required'
        ],[
            'Codigo_Producto.unique' => 'El Producto con esta descripcion ya existe en la plataforma.',
        ]);
        $producto = ProductoModelo::findOrFail($ID_Categoria);
        $producto->update([
            'Codigo_Producto' => $request->Codigo_Producto,
            'Cantidad' => $request->Cantidad,
            'Nombre' => $request->Nombre,
            'Descripcion' => $request->Descripcion,
            'Imagen' => $request->Imagen,
            'Precio' => $request->Precio,
            'Activo_Catalogo' => $request->Activo_Catalogo,
            'ID_Catalogo' => $request->ID_Catalogo,
        ]);
           return redirect()->route('producto.index')->with('success','Producto Actualizado en la Plataforma');

    }
    // Eliminar
public function destroy($id)
{
    $producto = ProductoModelo::findOrFail($id);
    $producto->delete();

    return redirect()->route('producto.index')->with('success', 'Producto eliminado correctamente');
}
}
