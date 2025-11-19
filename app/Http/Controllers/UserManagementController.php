<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        // Traemos usuarios con su rol
        $users = User::with('role')->get();

        return view('pages.user-management', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('nombre')->get();

        return view('pages.user-edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $data['role_id'] ?? null,
        ]);

        return redirect()->route('user-management')
            ->with('success', 'Rol asignado correctamente');

    }
}
