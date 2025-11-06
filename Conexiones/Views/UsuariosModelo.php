<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosModelo extends Model
{
    protected $table = 'usuario';

    protected $primaryKey = 'ID_Usuario';

    public $incrementing = false;

    protected $keyType = 'string'; 

    public $timestamps = false;

    protected $fillable = [
        'ID_Usuario',
        'Codigo_Documento',
        'Nombre',
        'Fecha_Nacimiento',
        'Direccion',
        'Telefono',
        'Correo',
        'Contraseña',
        'Codigo_Rol',
    ];
}
