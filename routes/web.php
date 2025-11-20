<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\DishController;

/*
|--------------------------------------------------------------------------
| Rutas públicas (invitados)
|--------------------------------------------------------------------------
*/

// Si no está logueado → login, si ya está logueado → dashboard
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : redirect()->route('login');
})->name('root');

Route::get('/p/{dish}', [DishController::class, 'publicShow'])
    ->name('dishes.public.show');

// Auth invitado
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');

    Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
    Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');

    Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
    Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
});

/*
|--------------------------------------------------------------------------
| Rutas comunes autenticadas (cualquier rol)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard principal (luego aquí podemos redirigir por rol si quieres)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    // Perfil (Admin, Chef y Cliente pueden ver/editar su perfil)
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Rutas ADMIN (puede acceder a todo)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {

    // Administración de usuarios (User Management)
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::get('/user-management/{user}/edit', [UserManagementController::class, 'edit'])->name('user-management.edit');
    Route::put('/user-management/{user}', [UserManagementController::class, 'update'])->name('user-management.update');

    // Roles
    Route::resource('roles', RoleController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Rutas ADMIN + CHEF (comparten platillos y categorías)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin|Chef'])->group(function () {

    // Categorías de comida
    Route::resource('categorias', FoodCategoryController::class)
        ->names('categorias')
        ->parameters(['categorias' => 'categoria']);

    // Platillos
    Route::resource('dishes', DishController::class);
});

/*
|--------------------------------------------------------------------------
| Rutas CLIENTE (además del profile que ya tiene)
|--------------------------------------------------------------------------
*/

// De momento solo perfil. Si luego quieres que vea el menú:
Route::middleware(['auth', 'role:Cliente'])->group(function () {

    // Ejemplo: menú solo lectura para el cliente
    // Route::get('/menu', [DishController::class, 'index'])->name('cliente.menu');

});
