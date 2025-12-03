@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Detalle del platillo'])

    @php
        // Foto del platillo
        $imageUrl = $dish->imagen
            ? asset('storage/' . $dish->imagen)
            : asset('img/default-dish.jpg');

        // ✅ URL PÚBLICA del platillo (la que verá el cliente al escanear el QR)
        $publicUrl = route('dishes.public', $dish);
    @endphp

    <div class="container-fluid py-4">

        {{-- TARJETA PRINCIPAL DEL PLATILLO --}}
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">{{ $dish->nombre }}</h6>

                <a href="{{ route('dishes.index') }}" class="btn btn-sm btn-secondary">
                    Volver a la lista
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- FOTO --}}
                    <div class="col-md-4">
                        <img src="{{ $imageUrl }}"
                             alt="Foto del platillo"
                             class="img-fluid border-radius-lg shadow-sm mb-3"
                             style="object-fit: cover; width: 100%; height: 260px;">

                        <p class="text-sm mb-1">
                            <strong>Categoría:</strong><br>
                            {{ optional($dish->categoria)->nombre ?? 'Sin categoría' }}
                        </p>

                        <p class="text-sm mb-1">
                            <strong>Precio:</strong><br>
                            ${{ number_format($dish->precio, 2) }}
                        </p>
                    </div>

                    {{-- TEXTOS --}}
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


        {{-- =============================
            SECCIÓN DEL CÓDIGO QR
        ============================== --}}
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Código QR del platillo</h6>

                {{-- ✅ BOTÓN PARA DESCARGAR QR QUE APUNTA A LA VISTA PÚBLICA --}}
                <a href="{{ 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&data=' . urlencode($publicUrl) }}"
                   download="qr-platillo-{{ $dish->id }}.png"
                   class="btn btn-sm btn-info">
                    Descargar QR
                </a>
            </div>

            <div class="card-body d-flex flex-column flex-md-row align-items-center">
                <div class="me-md-4 mb-3 mb-md-0 text-center">
                    {{-- ✅ QR MOSTRADO EN PANTALLA, TAMBIÉN APUNTA A LA VISTA PÚBLICA --}}
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->generate($publicUrl) !!}
                </div>

                <div>
                    <p class="text-sm">
                        Este código QR apunta a la URL:
                        <br>
                        <code class="text-xs">{{ $publicUrl }}</code>
                    </p>

                    <p class="text-xs text-muted mb-0">
                        Puedes imprimir este QR y colocarlo en la carta física del restaurante.
                        Al escanearlo, el cliente verá solo la vista pública del platillo
                        (información y modelo 3D), sin panel de administración.
                    </p>
                </div>
            </div>
        </div>


        {{-- =============================
            VISUALIZACIÓN 3D / AR
        ============================== --}}
        <div class="card">
            <div class="card-header pb-0">
                <h6>Visualización 3D / Realidad aumentada</h6>
            </div>
            <div class="card-body">
                @if($dish->modelo_3d)

                    <script type="module"
                            src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>

                    <model-viewer
                        src="{{ asset('storage/' . $dish->modelo_3d) }}"
                        ar
                        ar-modes="scene-viewer quick-look webxr"
                        camera-controls
                        auto-rotate
                        style="width: 100%; height: 400px; background: #f8f9fa; border-radius: 1rem;">
                    </model-viewer>

                    <p class="text-xs text-muted mt-2 mb-0">
                        En dispositivos compatibles, usa el botón de AR para ver el platillo en Realidad Aumentada.
                    </p>

                @else
                    <p class="text-sm text-muted mb-0">
                        Este platillo aún no tiene un modelo 3D cargado.
                    </p>
                @endif
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
