@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Mi perfil'])

    @php
        $user = auth()->user();
        $avatarUrl = $user->avatar
            ? asset('storage/' . $user->avatar)
            : asset('img/default-avatar.png'); // pon aquí tu imagen por defecto

    @endphp


    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <label for="avatar-input" class="w-100 h-100 m-0" style="cursor: pointer;">
                            <img src="{{ $avatarUrl }}" alt="profile_image" class="w-100 h-100 border-radius-lg shadow-sm" style="object-fit: cover; object-position: center;">
                            <span class="badge bg-primary position-absolute bottom-0 end-0" style="font-size: 0.65rem;">
                                CAMBIAR
                            </span>
                        </label>
                    </div>
                        </label>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->nombre ?? 'Nombre' }}
                            {{ $user->apellido_paterno ?? '' }}
                            {{ $user->apellido_materno ?? '' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Administrador del sistema
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="alert">
        @include('components.alert')
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            {{-- Solo dejamos el formulario, a lo ancho --}}
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Editar perfil</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Guardar</button>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- Input oculto para la foto de perfil (controlado por la imagen de arriba) --}}
                            <input id="avatar-input"
                                   type="file"
                                   name="avatar"
                                   accept="image/*"
                                   class="d-none">
                            @error('avatar')
                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                            @enderror
                            <small class="text-muted">
                                Haz clic en la imagen de perfil para seleccionar una nueva foto.
                            </small>

                            <hr class="horizontal dark">

                            {{-- Información de usuario --}}
                            <p class="text-uppercase text-sm">Información del usuario</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Usuario</label>
                                        <input class="form-control" type="text" name="username"
                                               value="{{ old('username', $user->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Correo electrónico</label>
                                        <input class="form-control" type="email" name="email"
                                               value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Nombre</label>
                                        <input class="form-control" type="text" name="nombre"
                                               value="{{ old('nombre', $user->nombre) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Apellido paterno</label>
                                        <input class="form-control" type="text" name="apellido_paterno"
                                               value="{{ old('apellido_paterno', $user->apellido_paterno) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Apellido materno</label>
                                        <input class="form-control" type="text" name="apellido_materno"
                                               value="{{ old('apellido_materno', $user->apellido_materno) }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark">

                            {{-- Información de contacto --}}
                            <p class="text-uppercase text-sm">Información de contacto</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Dirección</label>
                                        <input class="form-control" type="text" name="address"
                                               value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Ciudad</label>
                                        <input class="form-control" type="text" name="city"
                                               value="{{ old('city', $user->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">País</label>
                                        <input class="form-control" type="text" name="country"
                                               value="{{ old('country', $user->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Código postal</label>
                                        <input class="form-control" type="text" name="postal"
                                               value="{{ old('postal', $user->postal) }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark">

                            {{-- Sobre mí --}}
                            <p class="text-uppercase text-sm">Sobre mí</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Descripción</label>
                                        <input class="form-control" type="text" name="about"
                                               value="{{ old('about', $user->about) }}">
                                    </div>
                                </div>
                            </div>
                        </div> {{-- card-body --}}
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
