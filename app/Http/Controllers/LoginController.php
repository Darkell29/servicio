<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'usuario' => 'required',
            'contraseña' => 'required',
        ]);

        $credentials = $request->only('usuario', 'contraseña');

        // Buscar el usuario en la base de datos
        $user = Usuario::where('usuario', $credentials['usuario'])->first();

        // Verificar la contraseña
        if ($user && Hash::check($credentials['contraseña'], $user->contraseña)) {
            Auth::login($user);

            // Redirigir según el rol del usuario
            if ($user->rol == 1) {
                return redirect()->route('venta', ['user' => 'admin']);
            } elseif ($user->rol == 2) {
                return redirect()->route('venta', ['user' => 'vendedor']);
            }
        } else {
            // Si las credenciales no son correctas, regresar con un mensaje de error
            return back()->withErrors(['error' => 'Usuario o contraseña incorrectos.']);
        }
    }

    public function showVenta()
    {
        return view('venta');
    }

    public function showRegistros()
    {
        return view('registros');
    }
}
