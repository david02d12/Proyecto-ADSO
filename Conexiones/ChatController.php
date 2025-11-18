<?php

namespace App\Http\Controllers;
use App\Models\ChatModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    //Buscar y Paginar
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('chat');

        if($search){
            $query->where(function($q) use ($search){
                $q->where('Codigo_Chat', 'LIKE', "%{$search}%")
                ->orwhere('ID_Usuario', 'LIKE', "%{$search}%");

            });
        }
        $datos = $query->paginate(10);
        return view("chat")->with("datos", $datos);
    }

    //Insertar Datos
    public function store(Request $request){
        $request->validate([
            'Codigo_Chat' => 'required|unique:chat,Codigo_Chat',
            'ID_Usuario' => 'required',
            'ID_Servicio' => 'required'
        ],[
            'Codigo_Chat.unique' => 'La sala de chat con este codigo ya existe en la plataforma.',
        ]);

        ChatModelo::create($request->all());
        return redirect()->route('chat.index')->with('success','Sala de Chat Registrada en la Plataforma');
    }

    //Udate
    public function update(Request $request, $documento){
        $request->validate([
            'Codigo_Chat' => 'required|unique:chat,Codigo_Chat,'. $documento . ',Codigo_Chat',
            'ID_Usuario' => 'required',
            'ID_Servicio' => 'required'
        ],[
            'Codigo_Chat.unique' => 'La sala de chat con este codigo ya existe en la plataforma.',
        ]);
        $chat = ChatModelo::findOrFail($documento);
        $chat->update([
             'Codigo_Chat' => $request->Codigo_Chat,
             'ID_Usuario' => $request->ID_Usuario,
             'ID_Servicio' => $request->ID_Servicio,
        ]);
           return redirect()->route('chat.index')->with('success','Sala de chat Actualizada en la Plataforma');

    }
    // Eliminar
public function destroy($idocumento)
{
    $chat = ChatModelo::findOrFail($idocumento);
    $chat->delete();

    return redirect()->route('chat.index')->with('success', 'sala de chat eliminada correctamente');
}
}
