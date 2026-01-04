<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'metode_pembayaran' => 'required|in:qris,e_wallet,cash',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Cegah payment untuk event FREE
        if ($order->total_harga == 0) {
            return response()->json([
                'message' => 'Event gratis tidak memerlukan pembayaran'
            ], 400);
        }

        $payment = payment::create([
            'order_id' => $order->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'payment_reference' => 'PAY-' . strtoupper(Str::random(10)),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment berhasil dibuat',
            'data' => $payment
        ], 201);
    }

    public function callback(Request $request)
    {
        // dd($payment, $payment->order);
        $request->validate([
            'payment_reference' => 'required|string',
            'status' => 'required|in:success,failed',
        ]);

        $payment = payment::where('payment_reference', $request->payment_reference)
            ->first();

        if (!$payment) {
            return response()->json([
                'message' => 'Payment tidak ditemukan'
            ], 404);
        }

        DB::transaction(function () use ($payment, $request) {

            // Update payment
            $payment->status = $request->status;

            if ($request->status === 'success') {
                $payment->paid_at = now();
            }

            $payment->save();

            // Update order
            if ($request->status === 'success') {
                $payment->order->update([
                    'status_pembayaran' => 'success'
                ]);
            } else {
                $payment->order->update([
                    'status_pembayaran' => 'failed'
                ]);
            }
        });

        return response()->json([
            'message' => 'payment successfully'
        ]);
    }

}
