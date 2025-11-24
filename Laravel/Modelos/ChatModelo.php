<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ChatModelo extends Model
{
    protected $table = 'chat';

    protected $primaryKey = 'Codigo_Chat';

    public $incrementing = false;

    protected $keyType = 'varchar'; 

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Chat',
        'ID_Usuario',
        'ID_Servicio',
    ];
}
