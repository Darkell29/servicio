<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VentaController extends Controller
{
    
    public function getTicket($id)
{
    $venta = Venta::with(['cliente', 'detalles.servicio'])->find($id);

    if (!$venta) {
        return response()->json(['success' => false, 'message' => 'Venta no encontrada'], 404);
    }

    return response()->json(['success' => true, 'venta' => $venta]);
}   
    public function generateTicket($ventaId)
    {
        $venta = Venta::with(['cliente', 'detalles.servicio'])->find($ventaId);

        if (!$venta) {
            return response()->json(['success' => false, 'message' => 'Venta no encontrada']);
        }

        return response()->json([
            'success' => true,
            'venta' => $venta
        ]);
    }
  public function saveVenta(Request $request)
{
    DB::beginTransaction();
    try {
        $status = $request->input('advanceOption') == 'pagado' ? 'Pagado' : 'Pendiente';

        $cliente = Cliente::create([
            'nombre' => $request->input('name'),
            'telefono' => $request->input('phone'),
            'usuarios_id' => auth()->id(),
        ]);

        $venta = Venta::create([
            'cliente_id' => $cliente->id,
            'fecha_venta' => now(),
            'fecha_entrega' => $request->input('deliveryDate'),
            'anticipo' => $request->input('advanceOption') == 'anticipo' ? $request->input('advanceAmount') : ($request->input('advanceOption') == 'pagado' ? $request->input('totalSum') : 0),
            'total' => $request->input('totalSum'),
            'status' => $status,
        ]);

        $items = $request->input('items');
        if (!is_array($items) || empty($items)) {
            throw new \Exception('No hay items para procesar');
        }

        foreach ($items as $item) {
            if (!isset($item['serviceType'], $item['kilograms'], $item['total'])) {
                throw new \Exception('Faltan datos en el item: ' . json_encode($item));
            }

            $servicio = Servicio::where('tipo_servicio', $item['serviceType'])->first();

            if (!$servicio) {
                throw new \Exception('Servicio no encontrado: ' . $item['serviceType']);
            }

            DetalleVenta::create([
                'venta_id' => $venta->id,
                'servicio_id' => $servicio->id,
                'cantidad' => $item['kilograms'],
                'precio' => $item['total'],
            ]);
        }

        DB::commit();
        return response()->json(['message' => 'Venta guardada exitosamente', 'venta_id' => $venta->id], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al guardar la venta: ' . $e->getMessage());
        return response()->json(['message' => 'Error al guardar la venta: ' . $e->getMessage()], 500);
    }
}


    public function deleteVenta($id)
    {
        try {
            $venta = Venta::find($id);
            if ($venta) {
                $venta->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la venta: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }

    public function payRemaining(Request $request)
    {
        try {
            $venta = Venta::find($request->id);
            if ($venta) {
                $venta->anticipo += $request->amount;
                if ($venta->anticipo >= $venta->total) {
                    $venta->status = 'Pagado';
                }
                $venta->save();

                $paymentTicket = [
                    'venta_id' => $venta->id,
                    'amount' => $request->amount,
                    'remaining' => max(0, $venta->total - $venta->anticipo),
                ];

                return response()->json(['success' => true, 'payment_ticket' => $paymentTicket]);
            }
            return response()->json(['success' => false]);
        } catch (\Exception $e) {
            Log::error('Error al registrar el pago: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }
}
