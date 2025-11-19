<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username'          => ['required', 'max:255', 'min:2'],
            'nombre'            => ['nullable', 'max:100'],
            'apellido_paterno'  => ['nullable', 'string', 'max:255'],
            'apellido_materno'  => ['nullable', 'string', 'max:255'],
            'email'             => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'address'           => ['nullable', 'max:100'],
            'city'              => ['nullable', 'max:100'],
            'country'           => ['nullable', 'max:100'],
            'postal'            => ['nullable', 'max:100'],
            'about'             => ['nullable', 'max:255'],
            'avatar'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // 1) Si viene una nueva imagen, la guardamos en storage/app/public/avatars
        if ($request->hasFile('avatar')) {
            // Borrar la anterior si existía
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file     = $request->file('avatar');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Se guarda algo como "avatars/user_1_1731954860.jpg"
            $path = $file->storeAs('avatars', $filename, 'public');

            $user->avatar = $path;
        }

        // 2) Actualizamos el resto de datos
        $user->username         = $request->username;
        $user->nombre           = $request->nombre;
        $user->apellido_paterno = $request->apellido_paterno;
        $user->apellido_materno = $request->apellido_materno;
        $user->email            = $request->email;
        $user->address          = $request->address;
        $user->city             = $request->city;
        $user->country          = $request->country;
        $user->postal           = $request->postal;
        $user->about            = $request->about;

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente');
    }
}
