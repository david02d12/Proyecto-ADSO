<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NotifiacionesModelo extends Model
{
    protected $table = 'notificaciones';

    protected $primaryKey = 'Codigo_Notificaciones';

    public $incrementing = false;

    protected $keyType = 'numeric'; 

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Notificaciones',
        'Tipo_Notificacion',
    ];
}

