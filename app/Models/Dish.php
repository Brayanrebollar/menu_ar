<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'info_nutricional',
        'info_cultural',
        'ingredientes',
        'precio',
        'categoria_id',
        'imagen',      // ruta de la foto
        'modelo_3d',   // ruta del archivo 3D
    ];

    public function categoria()
    {
        return $this->belongsTo(FoodCategory::class, 'categoria_id');
    }


}
