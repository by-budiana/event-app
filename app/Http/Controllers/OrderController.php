<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(request $request)
    {
        $order = Order::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $order->where('status_pembayaran', 'like', "%$search%")
                  ->orWhere('email_pemesan', 'like', "%$search%")
                  ->orWhere('nomor_telepon', 'like', "%$search%");
        }
        return response()->json($order->paginate(10), 200);
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'total_harga' => 'required|integer|min:0',
            'metode_pembayaran' => 'nullable|in:qris,e_wallet,cash,free',
            'email_pemesan' => 'required|email',
            'nomor_telepon' => 'required|string'
        ]);
    
        $event = Event::find($request->event_id);
        $total_harga = $event->harga_tiket; 

        // LOGIC STATUS & METODE
        if ($total_harga == 0) {
            // EVENT FREE
            $status = 'paid';
            $metode = 'free';
        } elseif ($total_harga > 0) {
            // EVENT BERBAYAR
            $status = 'pending';
            $metode = $request->metode_pembayaran;
        }

        // SIMPAN DATA
        $order = Order::create([
            'event_id' => $request->event_id,
            'tanggal_order' => now(),
            'total_harga' => $request->total_harga,
            'status_pembayaran' => $status,
            'metode_pembayaran' => $metode,
            'email_pemesan' => $request->email_pemesan,
            'nomor_telepon' => $request->nomor_telepon
        ]);
        
       
        if ($total_harga == 0) {
            return response()->json([
                'message' => 'Pendaftaran berhasil (Event GRATIS)',
                'data' => $order
            ], 201);
        }
        else {
            return response()->json([
                'message' => 'Pendaftaran berhasil (Lanjutkan pembayaran)',
                'data' => $order
            ], 201);
        }


        
    }

    public function show(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // $request->validate([
        //     'total_harga' => 'required|integer|min:0',
        //     'status_pembayaran' => 'nullable|in:paid,pending,canceled',
        //     'metode_pembayaran' => 'nullable|in:qris,e_wallet,cash,free',
        //     'email_pemesan' => 'required|email',
        //     'nomor_telepon' => 'required|string'
        // ]);

        $order->update($request->only([
            'total_harga',
            'status_pembayaran',
            'metode_pembayaran',
            'email_pemesan',
            'nomor_telepon'
        ]));

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order
        ], 200);
    }

    public function destroy(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
