@include('layouts.head')
<div class="container">
    <div class="row justify-content-center"style="height: 100vh;">
        <div class="col-md-12 d-flex align-items-center justify-content-center">
            <div class="card card-info w-100">
                <div class="card-header">Registrasi Customer</div>
                <div class="card-body">

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name:</label>
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
                                    <label for="phone">Phone:</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username') }}">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            
                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder=""></textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Retry Password:</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        value="{{ old('password_confirmation') }}">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>
                        </div>
                        <div class="text-right mt-2">
                            <button type="submit" class="btn-sm btn btn-info w-100">
                                Create User
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
{{-- @push('javascript-bottom')
    @include('java_script.user_management.script')
@endpush --}}
