@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <h1 class="mb-4">顧客一覧</h1>
                <div class="row mb-4 justify-content-end">
                    <div class="col-lg-1 col-md-2 text-end"><a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">＋</a></div>

                    <table class="table table-bordered" id="tbl-customer" style="min-width: 65rem;">
                        <thead>
                            <tr class="text-center">
                                <th class="bg-gray">顧客名</th>
                                <th class="bg-gray">住所</th>
                                <th class="bg-gray">Tel</th>
                                <th class="bg-gray">見積</th>
                                <th class="bg-gray">受注</th>
                                <th class="bg-gray"></th>
                                <th class="bg-gray"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="align-middle">
                                    <td>{{ $customer['customer']->name }}</td>
                                    <td>{{ $customer['customer']->address }}</td>
                                    <td>{{ $customer['customer']->tel }}</td>
                                    <td class="text-end">{{ $customer['estimates_count'] }}件</td>
                                    <td class="text-end">
                                        {{$customer['order_rate']}}%
                                    </td>
                                    <td class="text-center"><a href="{{ route('customers.edit', $customer['customer']->id) }}"
                                            class="btn btn-primary btn-sm">編集</a></td>
                                    <td class="text-center">
                                        <form action="{{ route('customers.destroy', $customer['customer']->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
        jQuery(function($){
            $.extend( $.fn.dataTable.defaults, {
                language: {
                    url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
                }
            });
            let table = new DataTable('#tbl-customer',{
                "columnDefs": [
                    {
                        "targets":0,
                        "width": "16rem"
                    },
                    {
                        "targets":1,
                        "width": "22rem"
                    },
                    {
                        "targets":2,
                        "width": "7.5rem"
                    },
                    {
                        "targets":3,
                        "width": "3rem"
                    },
                    {
                        "targets":[5,6],
                        "width": "4rem"
                    },
                    {
                        "targets": [2, 3, 4,5,6],
                        "searchable": false,
                    },
                    {
                        "targets": [3, 4, 5, 6],
                        "sortable": false,
                    },
                ],
                "scrollX": true,
                "order": [],
            });
        });
    </script>
@endsection
