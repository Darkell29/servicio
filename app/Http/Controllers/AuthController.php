<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Venta;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('usuario', 'contraseña');

        if (Auth::attempt(['usuario' => $credentials['usuario'], 'password' => $credentials['contraseña']])) {
            $user = Auth::user();

            if ($user->rol == 1) {
                return redirect()->intended('registros'); // Redirigir a vista de administrador
            } elseif ($user->rol == 2) {
                return redirect()->intended('venta'); // Redirigir a vista de vendedor
            }
        }

        return back()->withErrors([
            'error' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function servi()
    {
        return view('servicios');
    }

    public function servi2()
    {
        return view('servicios');
    }

    public function regis(Request $request)
    {
        $user = Auth::user();
        $query = Venta::with(['cliente', 'detalles.servicio']);

        // Filtrar por cliente del usuario autenticado
        if ($user->rol != 1) { // Solo si el usuario no es administrador
            $query->whereHas('cliente', function($query) use ($user) {
                $query->where('usuarios_id', $user->id);
            });
        }

        // Filtrar por búsqueda de nombre de cliente
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('cliente', function($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        // Filtrar por fecha
        if ($request->has('filter')) {
            $filter = $request->get('filter');
            $today = now();
            switch ($filter) {
                case 'day':
                    $query->whereDate('fecha_venta', $today);
                    break;
                case 'week':
                    $query->whereBetween('fecha_venta', [$today->startOfWeek(), $today->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('fecha_venta', $today->month)->whereYear('fecha_venta', $today->year);
                    break;
                case 'year':
                    $query->whereYear('fecha_venta', $today->year);
                    break;
            }
        }

        // Filtrar por rango de fechas
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            $query->whereBetween('fecha_venta', [$startDate, $endDate]);
        }

        $ventas = $query->get();

        return view('registros', compact('ventas'));
    }
}
