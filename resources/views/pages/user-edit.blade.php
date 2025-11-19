@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Asignar rol'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Asignar rol a {{ $user->username ?? $user->name }}</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user-management.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select name="role_id" class="form-control">
                                    <option value="">Sin rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('user-management') }}" class="btn btn-secondary">
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
