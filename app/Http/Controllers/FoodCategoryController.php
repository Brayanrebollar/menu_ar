<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    // Listado + formulario de creación
    public function index()
    {
        $categorias = FoodCategory::orderBy('nombre')->get();

        return view('categorias.index', compact('categorias'));
    }

    // Guardar nueva categoría
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:food_categories,nombre',
        ]);

        FoodCategory::create($data);

        return back()->with('success', 'Categoría creada correctamente');
    }

    // Formulario de edición
    // OJO: si en routes usas ->parameters(['categorias' => 'categoria'])
    public function edit(FoodCategory $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    // Actualizar categoría
    public function update(Request $request, FoodCategory $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100|unique:food_categories,nombre,' . $categoria->id,
        ]);

        $categoria->update($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    // Eliminar categoría
    public function destroy(FoodCategory $categoria)
    {
        $categoria->delete();

        return back()->with('success', 'Categoría eliminada correctamente');
    }

    // Estos métodos no los usaremos, pero existen por el --resource
    public function create() {}
    public function show(FoodCategory $foodCategory) {}
}
