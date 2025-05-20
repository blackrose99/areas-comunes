<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validación básica
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4'
        ]);

        // Tomar solo email y password del request
        $credentials = $request->only('email', 'password');

        // Intento de login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => Auth::user()
            ]);
        }

        // Log de intento fallido
        Log::warning('Login fallido', [
            'email' => $credentials['email']
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Correo o contraseña incorrectos'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
