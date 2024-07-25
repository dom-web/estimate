@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Customers List</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Kana</th>
                    <th>ZIP</th>
                    <th>Address</th>
                    <th>Tel</th>
                    <th>Memo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->kana }}</td>
                        <td>{{ $customer->zip }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->tel }}</td>
                        <td>{{ $customer->memo }}</td>
                        <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
