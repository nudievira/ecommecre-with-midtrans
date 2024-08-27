@extends('layouts.main')
<style>
    .btn_create {
        float: right;
    }
</style>
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Product</h3>

                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Kuantitas</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $item)
                                        <tr>
                                            <td width="13%">{{ $item->name }}</td>
                                            <td width="5%">{{ $item->stock }}
                                                <input type="number" class="form-control"
                                                            min="1" value="{{ $item->stock }}" id="stock_{{ $item->id }}" hidden>
                                            </td>
                                            <td width="10%">Rp {{ number_format($item->price, 0, ',', '.') }}
                                                <input type="number" value="{{ $item->price }}" id="price_{{ $item->id }}" hidden>

                                            </td>
                                            <td>{{ $item->description }}</td>
                                            <td width="5%">
                                                <form action="{{ route('cart.store', $item->id) }}" method="POST">
                                                    {{-- <form action="#" method="POST"> --}}
                                                    @csrf
                                                    @if ($item->stock == 0)
                                                        <input type="number" class="form-control"
                                                            min="1" value="1" disabled>
                                                    @else
                                                        <input type="number" name="quantity" class="form-control"
                                                            min="1" value="1" id="qty_{{ $item->id }}" onchange="inputQty(this.value, {{ $item->id }})">
                                                    @endif


                                            </td>
                                            <td  width="10%">
                                                <input type="number" class="form-control" id="total_price_{{ $item->id }}" value="{{ $item->price }}" id="" disabled>
                                            </td>
                                            <td width="10%">
                                                @if ($item->stock == 0)
                                                    <button type="submit" class="btn btn-sm btn-primary" disabled><i
                                                            class="fas fa-shopping-cart"></i> Tambah</button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                                            class="fas fa-shopping-cart"></i> Tambah</button>
                                                @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('javascript-bottom')
        @include('javaScript.product.script')
    @endpush
@endsection
