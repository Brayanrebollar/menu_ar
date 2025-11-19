<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class DishController extends Controller
{
    // LISTAR
    public function index()
    {
        $dishes = Dish::with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('dishes.index', compact('dishes'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $categorias = FoodCategory::orderBy('nombre')->get();

        return view('dishes.create', compact('categorias'));
    }

    // GUARDAR PLATILLO
    public function store(Request $request)
    {
        // 1) Validar datos
        $data = $request->validate([
            'nombre'           => ['required', 'string', 'max:255'],
            'descripcion'      => ['nullable', 'string'],
            'info_nutricional' => ['nullable', 'string'],
            'info_cultural'    => ['nullable', 'string'],
            'ingredientes'     => ['nullable', 'string'],
            'precio'           => ['required', 'numeric', 'min:0'],
            'categoria_id'     => ['required', 'exists:food_categories,id'],

            // Archivos
            'imagen'    => ['nullable', 'image', 'max:2048'],         // jpg, png, etc.
            'modelo_3d' => ['nullable', 'file', 'max:10240'],          // 10 MB
        ]);

        // 2) Subir imagen si viene
        $imagePath = null;
        if ($request->hasFile('imagen')) {
            // se guarda en storage/app/public/dishes/images
            $imagePath = $request->file('imagen')->store('dishes/images', 'public');
        }

        // 3) Subir modelo 3D si viene
        $modelPath = null;
        if ($request->hasFile('modelo_3d')) {
            // se guarda en storage/app/public/dishes/models
            $modelPath = $request->file('modelo_3d')->store('dishes/models', 'public');
        }

        // 4) Crear registro en la BD
        Dish::create([
            'nombre'           => $data['nombre'],
            'descripcion'      => $data['descripcion'] ?? null,
            'info_nutricional' => $data['info_nutricional'] ?? null,
            'info_cultural'    => $data['info_cultural'] ?? null,
            'ingredientes'     => $data['ingredientes'] ?? null,
            'precio'           => $data['precio'],
            'categoria_id'     => $data['categoria_id'],
            'imagen'           => $imagePath,
            'modelo_3d'        => $modelPath,
        ]);

        return redirect()
            ->route('dishes.index')
            ->with('success', 'Platillo creado correctamente.');
    }
    public function show(Dish $dish)
    {
        // Nos aseguramos de cargar la categoría
        $dish->load('categoria');

        return view('dishes.show', compact('dish'));
    }
}
