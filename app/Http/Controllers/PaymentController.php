<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use App\Models\transaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'selectedData' => 'required|json',
                'tanggal' => 'required|date',
                'total_harga' => 'required|numeric|min:0'
            ]);

            // Parse data jadwal yang dipilih
            $selectedData = json_decode($request->selectedData, true);
            
            if (empty($selectedData)) {
                return response()->json(['error' => 'Tidak ada jadwal yang dipilih'], 400);
            }

            // Konfigurasi Midtrans
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Buat parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . time(),
                    'gross_amount' => (int) $request->total_harga,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'item_details' => array_map(function($jadwal) {
                    return [
                        'id' => $jadwal['idjadwal'],
                        'price' => (int) $jadwal['harga'],
                        'quantity' => 1,
                        'name' => 'Booking Lapangan'
                    ];
                }, $selectedData)
            ];

            // Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Buat transaksi di database
            $transaction = transaksiModel::create([
                'user_id' => Auth::id(),
                'tanggal' => $request->tanggal,
                'total_harga' => $request->total_harga,
                'status' => 'pending',
                'metode' => 'online',
                'snap_token' => $snapToken
            ]);

            // Buat booking untuk setiap jadwal yang dipilih
            foreach ($selectedData as $jadwal) {
                BookingModel::create([
                    'id_transaksi' => $transaction->id,
                    'id_jadwal' => $jadwal['idjadwal'],
                    'tanggal' => $request->tanggal,
                    'sub_total' => $jadwal['harga']
                ]);
            }

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Payment Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses pembayaran',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $payload = $request->all();
            
            Log::info('Midtrans Callback: ' . json_encode($payload));
            
            $orderId = explode('-', $payload['order_id'])[1];
            $transaction = transaksiModel::find($orderId);
            
            if (!$transaction) {
                Log::error('Transaction not found: ' . $orderId);
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            $transactionStatus = $payload['transaction_status'];
            $fraudStatus = $payload['fraud_status'];

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $transaction->status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $transaction->status = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $transaction->status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            }

            $transaction->save();
            Log::info('Transaction status updated: ' . $transaction->status);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function success()
    {
        return view('user.pages.payment.success');
    }

    public function pending()
    {
        return view('user.pages.payment.pending');
    }

    public function error()
    {
        return view('user.pages.payment.error');
    }
} 