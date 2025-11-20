@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Platillos'])

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Platillos del menú</h6>
                <a href="{{ route('dishes.create') }}" class="btn btn-sm btn-primary">
                    Agregar platillo
                </a>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Platillo
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Categoría
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Precio
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Detalles
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($dishes as $dish)
                            @php
                                $imageUrl = $dish->imagen
                                    ? asset('storage/' . $dish->imagen)
                                    : asset('img/default-dish.jpg');   // pon aquí tu imagen genérica
                            @endphp

                            <tr>
                                {{-- FOTO + NOMBRE DEL PLATILLO --}}
                                <td class="align-middle">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="mb-2">
                                            <img src="{{ $imageUrl }}"
                                                 alt="Foto {{ $dish->nombre }}"
                                                 class="border-radius-lg shadow-sm"
                                                 style="width: 120px; height: 120px; object-fit: cover;">
                                        </div>
                                        <span class="text-sm font-weight-bold">
                                            {{ $dish->nombre }}
                                        </span>
                                    </div>
                                </td>


                                {{-- CATEGORÍA --}}
                                <td class="align-middle">
                                    <span class="text-sm">
                                        {{ optional($dish->categoria)->nombre ?? 'Sin categoría' }}
                                    </span>
                                </td>

                                {{-- PRECIO --}}
                                <td class="align-middle">
                                    <span class="text-sm">
                                        ${{ number_format($dish->precio, 2) }}
                                    </span>
                                </td>

                                {{-- DETALLES (con saltos de línea) --}}
                                <td class="align-middle">
                                    <div class="text-xs text-secondary text-wrap"
                                         style="white-space: normal; max-width: 260px;">
                                        @if($dish->descripcion)
                                            <strong>Descripción:</strong>
                                            {{ $dish->descripcion }}<br>
                                        @endif

                                        @if($dish->info_nutricional)
                                            <strong>Info nutricional:</strong>
                                            {{ $dish->info_nutricional }}<br>
                                        @endif

                                        @if($dish->info_cultural)
                                            <strong>Info cultural:</strong>
                                            {{ $dish->info_cultural }}<br>
                                        @endif

                                        @if($dish->ingredientes)
                                            <strong>Ingredientes:</strong>
                                            {{ $dish->ingredientes }}
                                        @endif
                                    </div>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('dishes.show', $dish) }}"
                                       class="btn btn-sm btn-info me-2">
                                        Ver
                                    </a>

                                    <a href="{{ route('dishes.edit', $dish) }}"
                                       class="btn btn-sm btn-warning me-2">
                                        Editar
                                    </a>

                                    <form action="{{ route('dishes.destroy', $dish) }}"
                                          method="POST"
                                          style="display:inline-block"
                                          onsubmit="return confirm('¿Eliminar este platillo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-xs text-muted py-3">
                                    No hay platillos registrados aún.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection


