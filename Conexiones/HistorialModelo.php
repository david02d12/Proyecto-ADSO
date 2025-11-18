<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class HistorialModelo extends Model
{
    protected $table = 'Historial_Servicios';

    protected $primaryKey = 'ID_Historial';

    public $incrementing = false;

    protected $keyType = 'varchar';

    public $timestamps = false;

    protected $fillable = [
        'ID_Historial',
        'ID_Servicio',
        'Fecha_Evento',
        'Descripcion_Evento',
        'Estado',

    ];
}