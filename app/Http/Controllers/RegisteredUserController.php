<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Verifica si el usuario es un administrador antes de permitir el acceso
        if (auth()->user()->tipo === 'admin') {
            return view('admin.register');
        } else {
            return abort(403, 'No tienes permiso para acceder a esta página.');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        // Validar los campos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear el usuario con el tipo fijo "empleado"
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rfc' => $request->rfc,
            'tipo' => 'empleado', 
        ]);

        // Evento de registro
        event(new Registered($user));

        // Redirigir al inicio o donde sea necesario
        return redirect()->route('welcome')->with('success', 'Usuario registrado correctamente como médico.');
    }
}
