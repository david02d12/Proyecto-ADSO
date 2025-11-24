<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PreguntaModelo extends Model
{
    protected $table = 'pregunta';

    protected $primaryKey = 'ID_Consulta';

    public $incrementing = false;

    protected $keyType = 'numeric'; 

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Producto',
        'ID_Consulta',
        'ID_Usuario',
        'Pregunta',
        'Fecha',
        
    ];
}


