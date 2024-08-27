<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Transaction\Bucket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BucketController extends Controller
{
    public function store(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $bucket_data = Bucket::where('id_product', $id)->where('id_user', Auth::user()->id)->first();
            if ($bucket_data) {
                $total_qty = $bucket_data->qty + $request->quantity;
                $bucket_data->update([
                    'qty' => $total_qty
                ]);
                if ($bucket_data) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Add Product successfully.');
                } else {
                    return redirect()->back()->with('error', 'Add Product error.');
                }
            } else {
                $bucket = Bucket::lockForUpdate()->create([
                    'id_product' => $id,
                    'id_user' => Auth::user()->id,
                    'qty' => $request->quantity,
                    'created_at' => now()
                ]);
                if ($bucket) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Add Product successfully, cek your transaction');
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Add Product error.');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            dd($e);
            // return redirect()
            //     ->back()
            //     ->with(['failed' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $bucket_items = Bucket::where('id_user', Auth::user()->id)->with('product')->get();

        // Tambahkan total per produk ke setiap item di bucket_items
        $bucket_items->each(function ($item) {
            $item->total_price = $item->qty * $item->product->price;
        });

        return view('bucket.index', compact('bucket_items'));
    }

    public function updateQty(Request $request)
    {
        try {
            DB::beginTransaction();

            $bucket = Bucket::where('id', $request->idBucket)->update([
                'qty' => $request->qty
            ]);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            dd($e);
            // return redirect()
            //     ->back()
            //     ->with(['failed' => $e->getMessage()]);
        }
    }
}
