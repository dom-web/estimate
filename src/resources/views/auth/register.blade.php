@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card pt-3 pb-3">
                <div class="card-body">
                    <h2 class="card-title text-center text-primary mb-3">新規登録</h2>
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                        @error('name')
                        <div class="alert alert-danger col-md-10" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                        @error('email')
                        <div class="alert alert-danger col-md-10" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                        @error('password')
                        <div class="alert alert-danger col-md-10" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                        @error('avatar')
                        <div class="alert alert-danger col-md-10" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row justify-content-center mb-0">
                            <a href="{{ route('login') }}" class="btn btn-secondary col-3 me-3">戻る</a>
                            <button type="submit" class="btn btn-primary col-3">
                                 登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
