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
                            <h3 class="card-title">Cart</h3>

                        </div>

                        {{-- <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Kuantitas</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bucket_items as $item)
                                        <tr>
                                            <td width="3">{{ $loop->index+1 }}</td>
                                            <td width="13%">{{ $item->product->name }}</td>
                                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->product->description }}</td>
                                            <td width="5%">
                                                <input type="number" name="quantity" class="form-control" min="1"
                                                    value="{{ $item->qty }}">
                                            </td>
                                            <td width="10%"> <input class="form-control" type="text" value="{{ $item->total_price }}" name="" id="" readonly>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div> --}}
                        <div class="card-body">
                            <form id="bucketForm" method="POST" action="{{ route('transaction.store') }}">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Deskripsi</th>
                                            <th>Kuantitas</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bucket_items as $item)
                                            <tr>
                                                @if ($item->product->stock == 0)
                                                    <td width="2"><input type="checkbox" class="item-checkbox"
                                                            value="{{ $item->id }}" disabled></td>
                                                @else
                                                    <td width="2"><input type="checkbox" class="item-checkbox"
                                                            value="{{ $item->id }}"></td>
                                                @endif
                                                <td width="3">{{ $loop->index + 1 }}</td>
                                                <td width="13%">{{ $item->product->name }}</td>
                                                <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                    <input type="number" value="{{ $item->product->price }}"
                                                        id="price_{{ $item->id }}" hidden>
                                                    <input type="number" value="{{ $item->product->stock }}"
                                                        id="stock_{{ $item->id }}" hidden>
                                                </td>
                                                <td>{{ $item->product->description }}</td>
                                                <td width="5%">
                                                    <input type="number" name="quantity[]"
                                                        onchange="inputQty(this.value, {{ $item->id }})"
                                                        id="qty_{{ $item->id }}" class="form-control" min="1"
                                                        value="{{ $item->qty }}">
                                                </td>
                                                <td width="10%">
                                                    <input class="form-control" type="text"
                                                        value="{{ $item->total_price }}"
                                                        id="total_price_{{ $item->id }}" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-primary btn-sm btn_create">Check Out</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('javascript-bottom')
        @include('javaScript.bucket.script')
    @endpush
@endsection
