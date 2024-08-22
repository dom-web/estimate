@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold text-primary mb-4">アイテム一覧</h2>
                <p class="lead mb-4">見積作成用の項目（アイテム）の一覧です。
                </p>
                <div class="row justify-content-end">
                    <div class="col-lg-1 col-md-2 mb-4 text-end"><a href="{{ url('/admin/items/create') }}" class="btn btn-primary">＋</a></div>
                </div>
                <table class="table table-striped table-bordered" id="items-table">
                    <thead>
                        <tr class="text-center">
                            <th class="bg-gray">アイテム名</th>
                            <th class="bg-gray">カテゴリ</th>
                            <th class="bg-gray">中難易度単価</th>
                            <th class="bg-gray"></th>
                            <th class="bg-gray"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="align-middle{{$item->deleted_at ? ' deleted' : ''}}">
                                <td>{{ $item->name }}</td>
                                <td>
                                    @switch($item->category)
                                        @case(1)
                                            プロジェクト計画
                                        @break

                                        @case(2)
                                            デザイン
                                        @break

                                        @case(3)
                                            フロントエンド開発
                                        @break

                                        @case(4)
                                            バックエンド開発
                                        @break

                                        @case(5)
                                            インフラストラクチャ
                                        @break

                                        @case(6)
                                            コンテンツ作成
                                        @break

                                        @case(7)
                                            テスト
                                        @break

                                        @case(8)
                                            デプロイメント
                                        @break

                                        @case(9)
                                            保守・運用
                                        @break

                                        @case(10)
                                            ドキュメント
                                        @break
                                    @endswitch
                                </td>
                                <td class="text-end">{{ number_format($item->diff_mid) }}円</td>
                                <td class="text-center">
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary{{$item->deleted_at ? ' disabled' : ''}}">編集</a>
                                </td>
                                <td class="text-center">
                                    @if($item -> deleted_at)
                                    <form action="{{ route('items.restore', $item->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('本当に復元しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-info">復元</button>
                                    </form>
                                    @else
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary">削除</button>
                                    </form>
                                    @endif
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
            let table = new DataTable('#items-table',{
                "columnDefs": [
                    {
                    "targets": [2, 3, 4],
                    "searchable": false,
                    },
                    {
                    "targets": [3, 4],
                    "sortable": false,
                    },
                ],
                "order": [],
            });
        });
    </script>
@endsection
