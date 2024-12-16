<?php

namespace App\Http\Controllers;

use App\Models\transaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkoutController extends Controller
{
    public function process(Request $request)
    {
        $data = $request->all();

        $transaction =  transaksiModel::create([
            'user_id' => Auth::user()->id,
            'product_id' => $data['product_id'],
            'price' => $data['price'],
            'status' => 'pending',
        ]);

        \Midtrans\Config::$serverKey = 'SB-Mid-server-5ukGL1CMwEikmEYHbvOjjPnV';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();


        return redirect()->route('checkout', $transaction->id);
    }


    public function checkout(transaksiModel $transaction)
    {
        $products = config('products');
        $product =  collect($products)->firstWhere('id', $transaction->product_id);

        return view('checkout', compact('transaction', 'product'));
    }
}
