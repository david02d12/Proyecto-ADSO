<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ComentarModelo extends Model
{
    protected $table = 'comentario';

    protected $primaryKey = 'codigo_Comentario';

    public $incrementing = false;

    protected $keyType = 'numeric'; 

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Comentario',
        'Comentario',
        'Fecha_Comentario',
        'ID_Usuairo',
    ];
}

