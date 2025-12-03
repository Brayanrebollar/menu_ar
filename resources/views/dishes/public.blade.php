@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    {{-- NO usamos el sidenav en mobile si quieres luego lo ajustamos,
         pero por ahora reutilizamos el layout para tener estilos --}}

    @php
        $imageUrl = $dish->imagen
            ? asset('storage/' . $dish->imagen)
            : asset('img/default-dish.jpg');  // pon una imagen genérica en public/img
    @endphp

    {{-- Cargamos model-viewer solo aquí --}}
    <script type="module"
            src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

    <div class="container-fluid py-4">

        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $dish->nombre }}</h5>

                {{-- Si el usuario viene del panel puede regresar, si no, no pasa nada --}}
                @auth
                    <a href="{{ route('dishes.index') }}" class="btn btn-sm btn-secondary">
                        Volver al panel
                    </a>
                @endauth
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- FOTO + DATOS BÁSICOS --}}
                    <div class="col-md-4 mb-4">
                        <img src="{{ $imageUrl }}"
                             alt="Foto del platillo {{ $dish->nombre }}"
                             class="img-fluid border-radius-lg shadow-sm mb-3"
                             style="object-fit: cover; width: 100%; max-height: 260px;">

                        <p class="text-sm mb-1">
                            <strong>Categoría:</strong><br>
                            {{ optional($dish->categoria)->nombre ?? 'Sin categoría' }}
                        </p>

                        <p class="text-sm mb-1">
                            <strong>Precio:</strong><br>
                            ${{ number_format($dish->precio, 2) }}
                        </p>
                    </div>

                    {{-- INFORMACIÓN DETALLADA --}}
                    <div class="col-md-8">
                        @if($dish->descripcion)
                            <p class="text-sm">
                                <strong>Descripción:</strong><br>
                                {{ $dish->descripcion }}
                            </p>
                        @endif

                        @if($dish->info_nutricional)
                            <p class="text-sm">
                                <strong>Información nutricional:</strong><br>
                                {{ $dish->info_nutricional }}
                            </p>
                        @endif

                        @if($dish->info_cultural)
                            <p class="text-sm">
                                <strong>Información cultural:</strong><br>
                                {{ $dish->info_cultural }}
                            </p>
                        @endif

                        @if($dish->ingredientes)
                            <p class="text-sm mb-0">
                                <strong>Ingredientes:</strong><br>
                                {{ $dish->ingredientes }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MODELO 3D + AR --}}
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Ver en 3D / Realidad Aumentada</h6>
            </div>
            <div class="card-body">
                @if($dish->modelo_3d)
                    <model-viewer
                        src="{{ asset('storage/' . $dish->modelo_3d) }}"
                        ar
                        ar-modes="scene-viewer quick-look webxr"
                        camera-controls
                        auto-rotate
                        ios-src="{{ asset('storage/' . $dish->modelo_3d) }}" {{-- si usas .usdz para iOS puedes cambiar esto --}}
                        style="width: 100%; height: 420px; background: #f8f9fa; border-radius: 1rem;">
                    </model-viewer>

                    <p class="text-xs text-muted mt-2 mb-0">
                        En tu celular, toca el botón de AR que aparece sobre el modelo
                        para abrir la cámara y colocar el platillo en tu entorno.
                    </p>
                @else
                    <p class="text-sm text-muted mb-0">
                        Este platillo aún no tiene un modelo 3D disponible.
                    </p>
                @endif
            </div>
        </div>

    </div>
@endsection
