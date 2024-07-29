@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <h1 class="mb-4">顧客一覧</h1>
                <div class="row mb-4">
                    <div class="col-md-5 mb-4">
                        <input type="text" id="search" class="form-control" placeholder="顧客名で検索">
                    </div>
                    <div class="col-lg-1 col-md-2 offset-lg-6 offset-md-5 text-end"><a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">＋</a></div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>顧客名</th>
                                <th>住所</th>
                                <th>電話番号</th>
                                <th>見積数</th>
                                <th>受注率</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="align-middle">
                                    <td>{{ $customer->name }}</td>
                                    <td class="truncate">{{ $customer->address }}</td>
                                    <td>{{ $customer->tel }}</td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><a href="{{ route('customers.edit', $customer->id) }}"
                                            class="btn btn-primary">編集</a></td>
                                    <td class="text-center">
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- ページネーション -->
                <div id="pagination" class="d-flex justify-content-center"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var rowsPerPage = 10;
            var rows = $('tbody tr');
            var rowsCount = rows.length;
            var pageCount = Math.ceil(rowsCount / rowsPerPage);
            var numbers = $('#pagination');

            // ページネーションのリンクを生成
            for (var i = 0; i < pageCount; i++) {
                numbers.append('<a href="#" class="page-number">' + (i + 1) + '</a> ');
            }

            // 初期表示
            rows.hide();
            rows.slice(0, rowsPerPage).show();
            $('#pagination a:first').addClass('active');

            // ページネーションリンクのクリックイベント
            $('#pagination').on('click', 'a', function(e) {
                e.preventDefault();
                $('#pagination a').removeClass('active');
                $(this).addClass('active');
                var page = $(this).text() - 1;
                var start = page * rowsPerPage;
                var end = start + rowsPerPage;
                rows.hide();
                rows.slice(start, end).show();
            });

            // 検索機能の実装
            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                rows.hide();
                var filteredRows = rows.filter(function() {
                    return $(this).find('td:first').text().toLowerCase().indexOf(value) > -1;
                });
                var filteredCount = filteredRows.length;
                var filteredPageCount = Math.ceil(filteredCount / rowsPerPage);

                // ページネーションの更新
                $('#pagination').empty();
                for (var i = 0; i < filteredPageCount; i++) {
                    $('#pagination').append('<a href="#" class="page-number">' + (i + 1) + '</a> ');
                }
                $('#pagination a:first').addClass('active');

                // フィルタリングされた結果の表示
                filteredRows.slice(0, rowsPerPage).show();

                // ページネーションリンクのクリックイベントの再設定
                $('#pagination').on('click', 'a', function(e) {
                    e.preventDefault();
                    $('#pagination a').removeClass('active');
                    $(this).addClass('active');
                    var page = $(this).text() - 1;
                    var start = page * rowsPerPage;
                    var end = start + rowsPerPage;
                    filteredRows.hide();
                    filteredRows.slice(start, end).show();
                });
            });
        });
    </script>
@endsection
