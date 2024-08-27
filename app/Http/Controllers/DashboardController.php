<?php

namespace App\Http\Controllers;

use App\Models\Transaction\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            $today = now()->format('Y-m-d');

            // Query untuk status 1
            $transaction_proses = Transaction::where('status', 1)
                ->whereDate('created_at', $today)
                ->count();

            // Query untuk status 3
            $transaction_success = Transaction::where('status', 3)
                ->whereDate('created_at', $today)
                ->count();

            // Query untuk total price
            $total_price = Transaction::where('status', 3)
                ->whereDate('payment_date', $today)
                ->sum('total_price');

            $user_registration = User::role('customer')->count();

            $data['transactionProses'] = $transaction_proses;
            $data['transactionSuccess'] = $transaction_success;
            $data['totalPrice'] = $total_price;
            $data['userRegistration'] = $user_registration;
            return view('home', $data);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            // return redirect()
            //     ->back()
            //     ->with(['failed' => $e->getMessage()]);
        }
    }
}
