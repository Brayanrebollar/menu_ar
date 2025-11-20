@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Roles'])

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Formulario para crear rol --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Nuevo rol</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre del rol</label>
                                <input type="text" name="nombre" class="form-control"
                                       value="{{ old('nombre') }}">
                                @error('nombre')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"
                                          placeholder="Opcional">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Guardar rol</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Tabla de roles --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Roles del restaurante</h6>
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
                                        Descripción
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Acciones
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        {{-- NOMBRE --}}
                                        <td class="align-middle text-center">
                                            <span class="text-sm font-weight-bold">
                                                {{ $role->nombre }}
                                            </span>
                                        </td>

                                        {{-- DESCRIPCIÓN --}}
                                        <td class="align-middle text-center">
                                            <span class="text-sm">
                                                {{ $role->descripcion ?? '—' }}
                                            </span>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('roles.edit', $role) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Editar
                                                </a>

                                                <form action="{{ route('roles.destroy', $role) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Eliminar este rol?');">
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
                                        <td colspan="3" class="text-center text-xs text-muted py-4">
                                            No hay roles registrados aún.
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
