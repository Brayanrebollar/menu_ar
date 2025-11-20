@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])

    <div class="container-fluid py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header pb-0">
                <h6>Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                User
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Role
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Create date
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            @php
                                $avatarUrl = $user->avatar
                                    ? asset('storage/' . $user->avatar)
                                    : asset('img/default-avatar.png');  // mismo default que en el perfil
                            @endphp

                            <tr>
                                {{-- COLUMNA USUARIO + FOTO --}}
                                <td class="align-middle">
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ $avatarUrl }}"
                                                 alt="user-avatar"
                                                 class="avatar avatar-sm me-3 border-radius-lg"
                                                 style="object-fit: cover; object-position: center;">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                                {{ $user->username ?? $user->name }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- COLUMNA ROL --}}
                                <td class="align-middle">
                                    <span class="text-sm">
                                        {{ $user->role->nombre ?? 'Sin rol' }}
                                    </span>
                                </td>

                                {{-- COLUMNA FECHA --}}
                                <td class="align-middle">
                                    <span class="text-xs">
                                        {{ optional($user->created_at)->format('d/m/Y') ?? '-' }}
                                    </span>
                                </td>

                                {{-- COLUMNA ACCIÓN --}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('user-management.edit', $user) }}"
                                       class="btn btn-sm btn-primary">
                                        Editar
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
