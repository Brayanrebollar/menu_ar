@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar platillo'])

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <h6 class="mb-0">Editar platillo</h6>
                        <a href="{{ route('dishes.index') }}" class="btn btn-sm btn-secondary">
                            Volver
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('dishes.update', $dish) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label class="form-label">Nombre del platillo</label>
                                <input type="text"
                                       name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $dish->nombre) }}">
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          rows="3">{{ old('descripcion', $dish->descripcion) }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Información nutricional --}}
                            <div class="mb-3">
                                <label class="form-label">Información nutricional</label>
                                <textarea name="info_nutricional"
                                          class="form-control @error('info_nutricional') is-invalid @enderror"
                                          rows="3">{{ old('info_nutricional', $dish->info_nutricional) }}</textarea>
                                @error('info_nutricional')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Información cultural --}}
                            <div class="mb-3">
                                <label class="form-label">Información cultural</label>
                                <textarea name="info_cultural"
                                          class="form-control @error('info_cultural') is-invalid @enderror"
                                          rows="3">{{ old('info_cultural', $dish->info_cultural) }}</textarea>
                                @error('info_cultural')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Ingredientes --}}
                            <div class="mb-3">
                                <label class="form-label">Ingredientes</label>
                                <textarea name="ingredientes"
                                          class="form-control @error('ingredientes') is-invalid @enderror"
                                          rows="3">{{ old('ingredientes', $dish->ingredientes) }}</textarea>
                                @error('ingredientes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Precio --}}
                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <input type="number"
                                       name="precio"
                                       step="0.01"
                                       min="0"
                                       class="form-control @error('precio') is-invalid @enderror"
                                       value="{{ old('precio', $dish->precio) }}">
                                @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Categoría --}}
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select name="categoria_id"
                                        class="form-select @error('categoria_id') is-invalid @enderror">
                                    <option value="">-- Selecciona una categoría --</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ old('categoria_id', $dish->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            {{-- Imagen actual --}}
                            <div class="mb-3">
                                <label class="form-label d-block">Imagen del platillo</label>

                                @if($dish->imagen)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $dish->imagen) }}"
                                             alt="Imagen actual"
                                             class="img-fluid border-radius-lg"
                                             style="max-height: 160px; object-fit: cover;">
                                    </div>
                                @endif

                                <input type="file"
                                       name="imagen"
                                       class="form-control @error('imagen') is-invalid @enderror">
                                <small class="text-muted">
                                    Deja este campo vacío si no quieres cambiar la imagen.
                                </small>
                                @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Modelo 3D --}}
                            <div class="mb-3">
                                <label class="form-label">Modelo 3D</label>
                                @if($dish->modelo_3d)
                                    <p class="text-xs text-muted mb-1">
                                        Archivo actual:
                                        <strong>{{ basename($dish->modelo_3d) }}</strong>
                                    </p>
                                @endif

                                <input type="file"
                                       name="modelo_3d"
                                       class="form-control @error('modelo_3d') is-invalid @enderror">
                                <small class="text-muted">
                                    Deja este campo vacío si no quieres cambiar el modelo 3D.
                                </small>
                                @error('modelo_3d')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('dishes.index') }}" class="btn btn-light me-2">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Actualizar platillo
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
