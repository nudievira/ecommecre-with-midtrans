<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function dataTable(Request $request)
    {
        $user = Product::get();
        if ($request->ajax()) {

            $data_tables = DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">NonActive</span>';
                    }
                })
                ->addColumn('price', function ($data) {
                    return 'Rp ' . number_format($data->price, 0, ',', '.');
                })


                ->addColumn('action', function ($data) {
                    $btn_action = '
                    <button class="btn btn-sm btn-primary my-1" onClick="show(' . $data->id . ')" title="Detail"><i class="fas fa-eye"></i></button>&nbsp
                    <button class="btn btn-sm btn-success my-1" onClick="edit(' . $data->id . ')" title="Edit"><i class="fas fa-edit"></i></button>&nbsp
                    ';

                    return $btn_action;
                })
                ->rawColumns(['action', 'status', 'price'])
                ->make(true);

            return $data_tables;
        }
    }


    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $product = Product::create($data);
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            dd($e);
            // return redirect()
            //     ->back()
            //     ->with(['failed' => $e->getMessage()]);
        }
    }

    public function show(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $product->productCreated = $product->created_at->format('d F Y');
        $product->productUpdated = $product->updated_at->format('d F Y');
        $product->formatPrice = 'Rp ' . number_format($product->price, 0, ',', '.');
        if ($product->status == 1) {
            $product->statusProduct = 'Active';
        } else {
            $product->statusProduct = 'NonActive';
        }


        return $product;
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $product = Product::where('id', $request->id)->update($data);
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product Update successfully.');
        } catch (Exception $e) {
            dd($e);
            // return redirect()
            //     ->back()
            //     ->with(['failed' => $e->getMessage()]);
        }
    }

}
