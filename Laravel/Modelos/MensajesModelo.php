<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MensajesModelo extends Model
{
    protected $table = 'mensajes';

    protected $primaryKey = 'Codigo_Mensaje';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Mensaje',
        'Codigo_Chat',
        'ID_Usuario',
        'Fecha_Mensaje',
        'Mensaje',
        'Estado',

    ];
}