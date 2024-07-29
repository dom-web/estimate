@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="mb-4">顧客情報・編集</h1>
        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group row mb-2">
                <label for="name" class="col-2">顧客名</label>
                <div class="col-8 col-md-5">
                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="kana" class="col-2">フリガナ</label>
                <div class="col-8 col-md-5">
                <input type="text" class="form-control" id="kana" name="kana" value="{{ $customer->kana }}" required>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="zip" class="col-2">郵便番号</label>
                <div class="col-4 col-md-2">
                <input type="text" class="form-control" id="zip" name="zip" value="{{ $customer->zip }}" required>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="address" class="col-2">住所</label>
                <div class="col-12 col-md-10">
                <textarea class="form-control" id="address" name="address" required>{{ $customer->address }}</textarea>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="tel" class="col-2">電話番号</label>
                <div class="col-5 col-md-4">
                <input type="text" class="form-control" id="tel" name="tel" value="{{ $customer->tel }}" required>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="memo" class="col-2">メモ</label>
                <div class="col-12 col-md-10">
                <textarea class="form-control" id="memo" name="memo">{{ $customer->memo }}</textarea>
                </div>
            </div>
            <div class="text-center"><button type="submit" class="btn btn-primary btn-lg">編集</button></div>
        </form>
    </div>
@endsection
