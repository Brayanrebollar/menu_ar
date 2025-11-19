@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Agregar platillo'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('dishes.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-header pb-0">
                            <h6>Agregar nuevo platillo</h6>
                        </div>

                        <div class="card-body">

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label class="form-label">Nombre del platillo</label>
                                <input type="text" name="nombre" class="form-control"
                                       value="{{ old('nombre') }}">
                            </div>

                            {{-- Descripción --}}
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control"
                                          rows="2">{{ old('descripcion') }}</textarea>
                            </div>

                            {{-- Info nutricional --}}
                            <div class="mb-3">
                                <label class="form-label">Información nutricional</label>
                                <textarea name="info_nutricional" class="form-control"
                                          rows="2">{{ old('info_nutricional') }}</textarea>
                            </div>

                            {{-- Info cultural --}}
                            <div class="mb-3">
                                <label class="form-label">Información cultural</label>
                                <textarea name="info_cultural" class="form-control"
                                          rows="2">{{ old('info_cultural') }}</textarea>
                            </div>

                            {{-- Ingredientes --}}
                            <div class="mb-3">
                                <label class="form-label">Ingredientes</label>
                                <textarea name="ingredientes" class="form-control"
                                          rows="2">{{ old('ingredientes') }}</textarea>
                            </div>

                            {{-- Precio --}}
                            <div class="mb-3">
                                <label class="form-label">Precio</label>
                                <input type="number" step="0.01" min="0"
                                       name="precio" class="form-control"
                                       value="{{ old('precio') }}">
                            </div>

                            {{-- Categoría --}}
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select name="categoria_id" class="form-control">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Imagen --}}
                            <div class="mb-3">
                                <label class="form-label">Cargar foto del platillo</label>
                                <input type="file" name="imagen" class="form-control">
                            </div>

                            {{-- Modelo 3D --}}
                            <div class="mb-3">
                                <label class="form-label">Cargar modelo 3D</label>
                                <input type="file" name="modelo_3d" class="form-control">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    Guardar platillo
                                </button>
                            </div>

                        </div> {{-- card-body --}}
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
