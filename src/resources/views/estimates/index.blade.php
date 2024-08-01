@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>見積もり一覧</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>更新日</th>
                    <th>社名</th>
                    <th>見積もり名</th>
                    <th>合計金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estimates as $estimate)
                    <tr>
                        <td>{{ $estimate->updated_at }}</td>
                        <td>{{ $estimate->customer->name }}</td>
                        <td>{{ $estimate->name }}</td>
                        <td>{{ $estimate->total_cost }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
