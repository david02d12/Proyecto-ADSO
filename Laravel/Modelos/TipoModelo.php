<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TipoModelo extends Model
{
    protected $table = 'tipo_documento';

    protected $primaryKey = 'Codigo_Documento';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Documento',
        'Nombre_Documento',
    ];
}
