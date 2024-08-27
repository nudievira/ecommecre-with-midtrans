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
                            {{-- <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm btn_create">Create
                                Product</a> --}}
                            <button type="button" class="btn btn-primary btn-sm btn_create" data-toggle="modal"
                                data-target="#exampleModal">
                                Create Product
                            </button>

                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <!-- Modal Add Product-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('product.store') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-row">
                                                <!-- Kolom Kiri -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name Product:</label>
                                                        <input type="text" name="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            value="{{ old('name') }}">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="stock">Stock:</label>
                                                        <input type="text" name="stock"
                                                            class="form-control @error('stock') is-invalid @enderror"
                                                            oninput="validateInput(this)" value="{{ old('stock') }}">
                                                        @error('stock')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="price">Price:</label>
                                                        <input type="text" name="price"
                                                            class="form-control @error('price') is-invalid @enderror"
                                                            oninput="validateInput(this)" value="{{ old('price') }}">
                                                        @error('price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                <!-- Kolom Kanan -->
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select name="status" class="form-control">
                                                            <option value="" hidden>--Select Status--</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">NonActive</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>

                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                                            placeholder=""></textarea>
                                                        @error('description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Show Product-->
                        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Show Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Product -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('product.update') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-row">
                                                <!-- Kolom Kiri -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" id="idProduct" name="id" hidden>
                                                        <label for="name">Name Product:</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control @error('name') is-invalid @enderror">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="stock">Stock:</label>
                                                        <input type="text" name="stock" id="stock"
                                                            class="form-control @error('stock') is-invalid @enderror"
                                                            oninput="validateInput(this)">
                                                        @error('stock')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="price">Price:</label>
                                                        <input type="text" name="price" id="price"
                                                            class="form-control @error('price') is-invalid @enderror"
                                                            oninput="validateInput(this)">
                                                        @error('price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- Kolom Kanan -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status">Status:</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="" hidden>--Select Status--</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">NonActive</option>
                                                        </select>
                                                        @error('status')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                                            rows="3"></textarea>
                                                        @error('description')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
