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
                            <h3 class="card-title">Product Management</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('javascript-bottom')
        @include('javaScript.transaction.script')
    @endpush
@endsection
