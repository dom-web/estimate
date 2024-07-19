@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card pt-3 pb-3">
                <div class="card-body">
                    <h2 class="card-title text-center text-primary mb-4">Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                        @error('password')
                            <div class="alert alert-danger" role="alert">
                                <span>{{ $message }}</span>
                            </span>
                        @enderror
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">


                            </div>
                        </div>

                        <div class="row justify-content-center mb-0">
                            <button type="submit" class="btn btn-primary col-4">
                                {{ __('Login') }}
                            </button>
                            <a href="{{ route('register') }}" class="btn btn-secondary ms-3 col-4">新規登録</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
