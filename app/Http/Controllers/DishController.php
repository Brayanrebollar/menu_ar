<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $data = $request->validate([
            'nombre'           => ['required', 'string', 'max:255'],
            'descripcion'      => ['nullable', 'string'],
            'info_nutricional' => ['nullable', 'string'],
            'info_cultural'    => ['nullable', 'string'],
            'ingredientes'     => ['nullable', 'string'],
            'precio'           => ['required', 'numeric', 'min:0'],
            'categoria_id'     => ['required', 'exists:food_categories,id'],
            'imagen'           => ['nullable', 'image', 'max:2048'],
            'modelo_3d'        => ['nullable', 'file', 'max:10240'],
        ]);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('dishes/images', 'public');
        }

        $modelPath = null;
        if ($request->hasFile('modelo_3d')) {
            $modelPath = $request->file('modelo_3d')->store('dishes/models', 'public');
        }

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

    // MOSTRAR DETALLE
    public function show(Dish $dish)
    {
        $dish->load('categoria');

        return view('dishes.show', compact('dish'));
    }

    // FORMULARIO EDITAR
    public function edit(Dish $dish)
    {
        $categorias = FoodCategory::orderBy('nombre')->get();

        return view('dishes.edit', compact('dish', 'categorias'));
    }

    // ACTUALIZAR PLATILLO
    public function update(Request $request, Dish $dish)
    {
        $data = $request->validate([
            'nombre'           => ['required', 'string', 'max:255'],
            'descripcion'      => ['nullable', 'string'],
            'info_nutricional' => ['nullable', 'string'],
            'info_cultural'    => ['nullable', 'string'],
            'ingredientes'     => ['nullable', 'string'],
            'precio'           => ['required', 'numeric', 'min:0'],
            'categoria_id'     => ['required', 'exists:food_categories,id'],
            'imagen'           => ['nullable', 'image', 'max:2048'],
            'modelo_3d'        => ['nullable', 'file', 'max:10240'],
        ]);

        // Si sube NUEVA imagen
        if ($request->hasFile('imagen')) {
            // borrar la anterior (si había)
            if ($dish->imagen && Storage::disk('public')->exists($dish->imagen)) {
                Storage::disk('public')->delete($dish->imagen);
            }
            $dish->imagen = $request->file('imagen')->store('dishes/images', 'public');
        }

        // Si sube NUEVO modelo 3D
        if ($request->hasFile('modelo_3d')) {
            if ($dish->modelo_3d && Storage::disk('public')->exists($dish->modelo_3d)) {
                Storage::disk('public')->delete($dish->modelo_3d);
            }
            $dish->modelo_3d = $request->file('modelo_3d')->store('dishes/models', 'public');
        }

        // Actualizar campos simples
        $dish->update([
            'nombre'           => $data['nombre'],
            'descripcion'      => $data['descripcion'] ?? null,
            'info_nutricional' => $data['info_nutricional'] ?? null,
            'info_cultural'    => $data['info_cultural'] ?? null,
            'ingredientes'     => $data['ingredientes'] ?? null,
            'precio'           => $data['precio'],
            'categoria_id'     => $data['categoria_id'],
            // 'imagen' y 'modelo_3d' ya se asignaron arriba si cambiaron
        ]);

        return redirect()
            ->route('dishes.index')
            ->with('success', 'Platillo actualizado correctamente.');
    }

    // (Opcional) ELIMINAR, por si aún no lo tienes
    public function destroy(Dish $dish)
    {
        if ($dish->imagen && Storage::disk('public')->exists($dish->imagen)) {
            Storage::disk('public')->delete($dish->imagen);
        }

        if ($dish->modelo_3d && Storage::disk('public')->exists($dish->modelo_3d)) {
            Storage::disk('public')->delete($dish->modelo_3d);
        }

        $dish->delete();

        return redirect()
            ->route('dishes.index')
            ->with('success', 'Platillo eliminado correctamente.');
    }
    public function showPublic(Dish $dish)
    {
        // Cargar categoría para mostrarla en la vista
        $dish->load('categoria');

        return view('dishes.public', compact('dish'));
    }
    public function downloadQr(Dish $dish)
    {
        // URL a la que apuntará el QR
        // si ya tienes showPublic(), puedes usar route('dishes.public', $dish)
        $url = route('dishes.show', $dish);

        // Generamos el QR en SVG (no requiere imagick)
        $svg = QrCode::format('svg')
            ->size(600)
            ->generate($url);

        // Nombre del archivo que se descargará
        $fileName = 'qr-platillo-' . $dish->id . '.svg';

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
