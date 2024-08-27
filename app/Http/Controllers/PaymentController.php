<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$clientKey = config('services.midtrans.client_key');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        // \Midtrans\Config::$isProduction = config('services.midtrans.environment');
        Config::$isProduction = false;

    }
    

    public function createTransaction(Request $request)
    {
        $transactionDetails = [
            'order_id' => rand(),
            'gross_amount' => $request->amount,
        ];

        $itemDetails = [
            [
                'id' => $request->order_id,
                'price' => $request->amount,
                'quantity' => 1,
                'name' => 'Product Name', // Customize as needed
            ]
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::createTransaction($transactionData)->token;
            // dd($snapToken);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        // Handle payment callback here
        // Process the response from Midtrans
    }
}
