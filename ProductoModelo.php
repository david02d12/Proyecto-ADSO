<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductoModelo extends Model
{
    protected $table = 'producto';

    protected $primaryKey = 'Codigo_Producto';

    public $incrementing = false;

    protected $keyType = 'numeric'; 

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Producto',
        'Cantidad',
        'Nombre',
        'Precio',
        'Descripcion',
        'Imagen',
        'Activo_Catalogo',
        'ID_Categoria',
        
    ];
}

