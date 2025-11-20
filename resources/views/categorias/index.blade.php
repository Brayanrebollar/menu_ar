@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Categorías'])

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Formulario para crear categoría --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Nueva categoría</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categorias.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nombre de la categoría</label>
                                <input type="text" name="nombre" class="form-control"
                                       value="{{ old('nombre') }}">
                                @error('nombre')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Guardar categoría
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Tabla de categorías --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Categorías de comida</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nombre
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($categorias as $categoria)
                                    <tr>
                                        {{-- NOMBRE --}}
                                        <td class="align-middle text-center">
                                            <span class="text-sm font-weight-bold">
                                                {{ $categoria->nombre }}
                                            </span>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('categorias.edit', $categoria) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Editar
                                                </a>

                                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Eliminar esta categoría?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-xs text-muted py-4">
                                            No hay categorías registradas aún.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
