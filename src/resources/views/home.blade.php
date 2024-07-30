@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="{{ route('estimate.store') }}">
                @csrf
                <div>
                    <label for="name">Estimate Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="customer_id">Customer ID:</label>
                    <input type="number" id="customer_id" name="customer_id" required>
                </div>
                <div>
                    <label for="person">Person:</label>
                    <input type="text" id="person" name="person" required>
                </div>
                <div>
                    <label for="issue_date">Issue Date:</label>
                    <input type="date" id="issue_date" name="issue_date" required>
                </div>
                <div>
                    <label for="limit_date">Limit Date:</label>
                    <input type="date" id="limit_date" name="limit_date" required>
                </div>
                <div>
                    <label for="memo">Memo:</label>
                    <textarea id="memo" name="memo"></textarea>
                </div>
                <div>
                    <input type="hidden" id="user_id" name="user_id" required value="{{ Auth::user()->id }}">
                </div>
                <div id="items-container"></div>
                <button type="button" id="add-item" hx-get="/item-box" hx-trigger="click" hx-target="#items-container" hx-swap="beforeend">Add Item</button>

                <h2>Total: ￥<span id="total-price">0</span></h2>
                <button type="submit">Create Estimate</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
