@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row mb-4">
                    <div class="col-md-5 mb-sm-4">
                        <select id="category-filter" class="form-select">
                            <option value="">すべてのカテゴリー</option>
                            <option value="プロジェクト計画">プロジェクト計画</option>
                            <option value="デザイン">デザイン</option>
                            <option value="フロントエンド開発">フロントエンド開発</option>
                            <option value="バックエンド開発">バックエンド開発</option>
                            <option value="インフラストラクチャ">インフラストラクチャ</option>
                            <option value="コンテンツ作成">コンテンツ作成</option>
                            <option value="テスト">テスト</option>
                            <option value="デプロイメント">デプロイメント</option>
                            <option value="保守・運用">保守・運用</option>
                            <option value="ドキュメント">ドキュメント</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 offset-lg-6 offset-md-5 text-end"><a href="{{ url('/admin/items/create') }}" class="btn btn-primary">＋</a></div>
                </div>
                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th>アイテム名</th>
                            <th>カテゴリ</th>
                            <th>中難易度単価</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="align-middle">
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
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary">編集</a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST"
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
        </div>
    </div>
@endsection


@section('scripts')
    <!-- jQuery UIのCDNを追加 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            // カテゴリーでの絞り込み機能
            $("#category-filter").change(function() {
                var selectedCategory = $(this).val();
                if (selectedCategory) {
                    $("#items-table tbody tr").filter(function() {
                        $(this).toggle($(this).find('td:nth-child(2)').text().trim() == selectedCategory);
                    });
                } else {
                    $("#items-table tbody tr").show();
                }
            });
        });
    </script>
@endsection
