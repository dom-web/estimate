@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Customer</h1>
        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
            </div>
            <div class="form-group">
                <label for="kana">Kana</label>
                <input type="text" class="form-control" id="kana" name="kana" value="{{ $customer->kana }}" required>
            </div>
            <div class="form-group">
                <label for="zip">ZIP</label>
                <input type="text" class="form-control" id="zip" name="zip" value="{{ $customer->zip }}" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $customer->address }}" required>
            </div>
            <div class="form-group">
                <label for="tel">Tel</label>
                <input type="text" class="form-control" id="tel" name="tel" value="{{ $customer->tel }}" required>
            </div>
            <div class="form-group">
                <label for="memo">Memo</label>
                <textarea class="form-control" id="memo" name="memo">{{ $customer->memo }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
        </form>
    </div>
@endsection
