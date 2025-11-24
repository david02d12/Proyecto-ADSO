<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RolesModelo extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'Codigo_Rol';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Rol',
        'Descripcion_Rol',
    ];
}
