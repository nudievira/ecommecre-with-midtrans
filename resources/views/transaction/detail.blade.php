@extends('layouts.main')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Profil</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%" style="text-align: left;">Invoice</th>
                                            <td width="60%">{{ $data->invoice }}</td>
                                        </tr>
                                        <tr>
                                            <th width="40%" style="text-align: left;">Status</th>
                                            <td>
                                                @if ($data->status == 1)
                                                    <span class="badge badge-warning">Proses</span>
                                                @else
                                                    <span class="badge badge-success">Success</span>
                                                @endif

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <h1>Request Item</h1>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <h5>Special Project Request</h5> --}}
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="5%">No</th>
                                                <th class="text-center" width="25%">Product Name</th>
                                                <th class="text-center" width="10%">Qty</th>
                                                <th class="text-center" width="25%">Price</th>
                                                <th class="text-center" width="25%">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // $i = 1;
                                                // $price_total = 0;
                                            @endphp
                                            @foreach ($data->transactionItem as $item)
                                                @php
                                                    // $price_total += $item->total;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td class="text-right">IDR {{ number_format($item->price, 2) }}</td>
                                                    <td style="text-align:end">
                                                        <div style="display: flex; justify-content: flex-end;">
                                                            <div style="margin-left: 10px"> IDR
                                                                {{ number_format($item->total, 0) }}</div>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Total</th>
                                                <td colspan="4" class="text-right">IDR
                                                    {{ number_format($data->total_price, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover table-striped">
                                            <!-- Existing table content -->
                                        </table>
                                    </div>
                                </div>
                                @if ($data->status == 1)
                                    <!-- Payment Button -->
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button id="pay-button" class="btn btn-primary">Pay Now</button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            {{-- <div class="row">
                                <div class="modal fade" id="modalReject" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reject Spr & Send Feedback
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('spr-reject') }}" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="discount" class="form-label">Discount</label>
                                                        <input type="number" name="discount" required min="0"
                                                            class="form-control">
                                                        <input type="hidden" name="id" required
                                                            value="{{ $model->Id }}">
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="Delivery" class="form-label">Delivery</label>
                                                        <input type="number" name="delivery" min="0"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="Payment" class="form-label">Payment</label>
                                                        <input type="number" name="payment" min="0"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="note" class="form-label">Note</label>
                                                        <textarea class="form-control" name="note" id="note" cols="30" rows="10" name="note"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-outline-danger">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            fetch('{{ route('payment.create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: '{{ $data->invoice }}',
                        amount: {{ $data->total_price }}
                    })
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.token, {
                        onSuccess: function(result) {
                            window.location.href =
                                '{{ route('transaction.payment', ['id' => $data->id]) }}';
                            // Handle success response here
                        },
                        onPending: function(result) {
                            console.log(result);
                            // Handle pending response here
                        },
                        onError: function(result) {
                            console.log(result);
                            // Handle error response here
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        };
    </script>
@endsection
{{-- @push('javascript-bottom')
    @include('java_script.user_management.script')
@endpush --}}
