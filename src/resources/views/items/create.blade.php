@extends('layouts.admin')

@section('content')
    <div class="container">
        {{ $defaults->diff_low ?? '' }}
        <form method="POST" action="{{route('items.store')}}">
            <input type="text" class="form-control">
        </form>
    </div>
@endsection
