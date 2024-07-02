<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{

    public function index2()
    {
        $services = Servicio::where('usuarios_id', auth()->id())->get();
        return response()->json($services);
    }

    public function store(Request $request)
    {

        Log::info('Request received:', $request->all());

        $service = new Servicio();
        $service->tipo_servicio = $request->tipo_servicio;
        $service->precio_por_unidad = $request->precio_por_unidad;
        $service->usuarios_id = auth()->id();
        $service->save();

        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = Servicio::findOrFail($id);
        $service->tipo_servicio = $request->tipo_servicio;
        $service->precio_por_unidad = $request->precio_por_unidad;
        $service->save();

        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = Servicio::findOrFail($id);
        $service->delete();

        return response()->json(['success' => true]);
    }
}
