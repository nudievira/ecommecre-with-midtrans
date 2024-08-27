<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Transaction\Bucket;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $selectedIds = $request->input('selected_ids');
            if (isset($selectedIds)) {
                $bucket = Bucket::whereIn('id', $selectedIds)->with('product')->get();
                $bucket_pluck = $bucket->pluck('product.id');
                $validBuckets = $bucket->filter(function ($item) {
                    return $item->qty <= $item->product->stock;
                });

                if ($validBuckets->count() !== $bucket->count()) {
                    return response()->json(['error' => 'Some items have quantities exceeding available stock.'], 400);
                }

                $bucket->each(function ($item) {
                    $item->total_price = $item->qty * $item->product->price;
                });
                $grand_total = $bucket->sum('total_price');
                $invoiceNumber = Transaction::generateInvoiceNumber();
                $transaction = Transaction::lockForUpdate()->create([
                    'invoice' => $invoiceNumber,
                    'total_price' => $grand_total,
                    'status' => Transaction::STATUS_PROCESS,
                    'created_at' => now(),
                    'id_user' => Auth::user()->id,
                ]);
                if ($transaction) {
                    foreach ($bucket as $item) {
                        $transaction_item = TransactionItem::lockForUpdate()->create([
                            'id_product' => $item->id_product,
                            'id_transaction' => $transaction->id,
                            'qty' => $item->qty,
                            'price' => $item->product->price,
                            'total' => $item->total_price,
                        ]);

                    }
                    Bucket::whereIn('id', $selectedIds)->delete();
                    DB::commit();
                    return response()->json(['success' => 'All items are valid and processed successfully.']);
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Transaction failed');
                }
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Please select your product');
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
        return view('transaction.index');
    }

    public function dataTable(Request $request)
    {
        $data = Transaction::where('id_user', Auth::user()->id)->get();
        if ($request->ajax()) {

            $data_tables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-warning">Proses</span>';
                    } else {
                        return '<span class="badge badge-success">Success</span>';
                    }
                })
                ->addColumn('totalPrice', function ($data) {
                    return 'Rp ' . number_format($data->total_price, 0, ',', '.');
                })


                ->addColumn('action', function ($data) {
                    $btn_action = '
                    <a href="' . route('transaction.show', ['id' => $data->id]) . '" class="btn btn-sm btn-primary my-1" title="Detail"><i class="fas fa-eye"></i> View</a>&nbsp';

                    return $btn_action;
                })
                ->rawColumns(['action', 'status', 'totalPrice'])
                ->make(true);

            return $data_tables;
        }
    }
    public function show($id)
    {
        $data = Transaction::where('id', $id)->with('transactionItem.product')->first();
        return view('transaction.detail', compact('data'));
    }

    public function payment($id)
    {
        try {
            DB::beginTransaction();
            $transaction_items = TransactionItem::where('id_transaction', $id)->get();
            $product_ids = $transaction_items->pluck('id_product');
            $products = Product::whereIn('id', $product_ids)->lockForUpdate()->get();

            foreach ($transaction_items as $item) {
                $product = $products->where('id', $item->id_product)->first();
                if ($product) {
                    $product->stock -= $item->qty;
                    $product->save();
                }
            }

            $data = Transaction::where('id', $id)->update([
                'status' => 3,
                'payment_date' => now(),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Payment success');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with(['failed' => $e->getMessage()]);
        }
    }
}
