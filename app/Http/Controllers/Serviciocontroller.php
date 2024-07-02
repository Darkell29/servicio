<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Support\Facades\Log;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();
        return response()->json($servicios);
    }

    public function store(Request $request)
    {
        Log::info('Request received:', $request->all());

        $validatedData = $request->validate([
            'tipo_servicio' => 'required|string|max:255',
            'precio_por_unidad' => 'required|numeric',
            'tipo' => 'required|string|max:45',
        ]);

        $validatedData['usuarios_id'] = auth()->id();

        $servicio = Servicio::create($validatedData);

        return response()->json($servicio);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipo_servicio' => 'required|string|max:255',
            'precio_por_unidad' => 'required|numeric',
            'tipo' => 'required|string|max:45',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($validatedData);

        return response()->json($servicio);
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado']);
    }
}
