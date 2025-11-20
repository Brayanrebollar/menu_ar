<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $dish->nombre }} - Menú AR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- model-viewer --}}
    <script type="module"
            src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js">
    </script>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            margin: 0;
            padding: 16px;
            background: #f5f5f5;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            max-width: 480px;
            margin: 0 auto;
        }
        .dish-image {
            width: 100%;
            border-radius: 12px;
            object-fit: cover;
            max-height: 260px;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin-top: 8px;
        }
        .btn-primary {
            background: #fb6340;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="card">
    {{-- Foto del platillo --}}
    @if($dish->imagen)
        <img src="{{ asset('storage/'.$dish->imagen) }}" alt="{{ $dish->nombre }}" class="dish-image">
    @endif

    <h2>{{ $dish->nombre }}</h2>
    <p><strong>Categoría:</strong> {{ optional($dish->categoria)->nombre ?? 'Sin categoría' }}</p>
    <p><strong>Precio:</strong> ${{ number_format($dish->precio, 2) }}</p>

    @if($dish->descripcion)
        <p><strong>Descripción:</strong> {{ $dish->descripcion }}</p>
    @endif

    @if($dish->info_nutricional)
        <p><strong>Información nutricional:</strong> {{ $dish->info_nutricional }}</p>
    @endif

    @if($dish->info_cultural)
        <p><strong>Información cultural:</strong> {{ $dish->info_cultural }}</p>
    @endif

    @if($dish->ingredientes)
        <p><strong>Ingredientes:</strong> {{ $dish->ingredientes }}</p>
    @endif

    {{-- Botón / bloque RA --}}
    @if($dish->modelo_3d)
        <details style="margin-top: 12px;">
            <summary class="btn btn-primary">
                Ver platillo en Realidad Aumentada
            </summary>

            <div style="margin-top: 12px;">
                <model-viewer
                    src="{{ asset('storage/'.$dish->modelo_3d) }}"
                    alt="Modelo 3D de {{ $dish->nombre }}"
                    ar
                    ar-modes="webxr scene-viewer quick-look"
                    camera-controls
                    auto-rotate
                    style="width: 100%; height: 320px; border-radius: 12px; background: #f0f0f0;">
                </model-viewer>
            </div>
        </details>
    @endif
</div>

</body>
</html>
