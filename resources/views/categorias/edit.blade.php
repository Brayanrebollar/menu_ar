@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar categoría'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Editar categoría</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nombre de la categoría</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control"
                                       value="{{ old('nombre', $categoria->nombre) }}">
                                @error('nombre')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
