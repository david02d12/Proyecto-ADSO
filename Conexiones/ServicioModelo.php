<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioModelo extends Model
{
    protected $table = 'servicio';

    protected $primaryKey = 'ID_Servicio';

    public $incrementing =true;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ID_Servicio',
        'Descripcion',
        'ID_Usuario',
        'Precio',
        'Movil_Nombre',
        'Movil_Especificacion',
        'Fecha',
        'Etapa',
        
    ];
}