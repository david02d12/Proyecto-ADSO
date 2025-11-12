<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CategoriaModelo extends Model
{
    protected $table = 'categoria';

    protected $primaryKey = 'ID_Categoria';

    public $incrementing = false;

    protected $keyType = 'int'; 

    public $timestamps = false;

    protected $fillable = [
        'ID_Categoria',
        'Nombre_Categoria',
    ];
}
