<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;

    // Nombre de la tabla (por si acaso)
    protected $table = 'food_categories';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'nombre',
    ];
}
