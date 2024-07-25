@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Add Customer</h1>
        <form method="POST" action="{{ route('customers.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="kana">Kana</label>
                <input type="text" class="form-control" id="kana" name="kana" required>
            </div>
            <div class="form-group">
                <label for="zip">ZIP</label>
                <input type="text" class="form-control" id="zip" name="zip" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="tel">Tel</label>
                <input type="text" class="form-control" id="tel" name="tel" required>
            </div>
            <div class="form-group">
                <label for="memo">Memo</label>
                <textarea class="form-control" id="memo" name="memo"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Customer</button>
        </form>
    </div>
@endsection
