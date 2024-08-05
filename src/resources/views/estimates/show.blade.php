@extends('layouts.app')
@section('content')
    <div class="container-lg">
        <div class="d-flex justify-content-between align-items-start">
        <div class="d-grid col-3 mb-3 d-print-none">
            <form action="{{ route('estimate.status.update', $estimate->id) }}" method="POST" class="d-print-none">
                @csrf
                @method('PUT')
                <div class="d-flex gap-4 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="issued" id="issued"
                            value="1"{{ $estimate->issued ? ' checked' : '' }} onchange="submit(this.form)">
                        <label class="form-check-label" for="issued">発行済</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ordered" id="ordered"
                            value="1"{{ $estimate->ordered ? ' checked' : '' }} onchange="submit(this.form)">
                        <label class="form-check-label" for="ordered">受注済</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="on_hold" id="on_hold"
                            value="1"{{ $estimate->on_hold ? ' checked' : '' }} onchange="submit(this.form)">
                        <label class="form-check-label" for="on_hold">保留</label>
                    </div>
                </div>
            </form>
            <select id="versionSelect" onchange="changeVersion()" class="form-select">
                @foreach ($estimate->items->groupBy('version') as $vs)
                    <option value="{{ $vs[0]->version }}" {{ $vs[0]->version == $version ? 'selected' : '' }}>
                        {{ $vs[0]->updated_at->format('Y年m月d日 H:i') }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="d-grid col-2">
        <button onclick="window.print(); return false;" class="d-print-none btn btn-primary btn-lg mt-3">印刷する</button >
        </div>

    </div>
    <form action="{{ route('estimate.destroy', $estimate->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
        <div class="card">
            <div class="card-body">
                <div class="text-end">{{ $items[0]->updated_at->format('Y年m月d日') }}</div>
                <div class="text-end">
                    見積番号：{{ sprintf('%03d', $customer->id) }}-{{ sprintf('%03d', $estimate->id) }}-{{ sprintf('%03d', $items[0]->version) }}
                </div>

                <h1 class="text-center fw-bold my-3">見積書</h1>
                <div class="row mb-5">
                    <div class="col-lg-3 col-5">
                        <h3>{{ $customer->name }} <small>御中</small></h3>
                        <h4 class="fs-5 mb-3">{{ $estimate->person }} <small>様</small></h4>
                        <div>件名：{{ $estimate->name }}</div>
                        <p>有効期限：{{ $estimate->limit_date->format('Y年m月d日') }}</p>
                        <p>下記のとおりお見積申し上げます。</p>
                        <div class="price d-flex justify-content-between align-items-baseline border-bottom">
                            <small>お見積金額</small>
                            <div class="fs-2 fw-bold"><span id="total"></span></div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-6 col-5 offset-2">
                        <p>EstiMeister株式会社</p>
                        <p>〒000-0000<br>
                            愛知県名古屋市中村区名駅1-1-1</p>
                        <p>tel:000-000-0000<br>
                            info@estimeister.com</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="bg-gray">項目</th>
                                <th class="bg-gray w-10">工数(人日)</th>
                                <th class="bg-gray w-10">単価</th>
                                <th class="bg-gray w-10">金額</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $all = 0;
                            @endphp
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->item->name }}</td>
                                    <td class="text-end">{{ $item->effort }}</td>
                                    <td class="text-end">
                                        {{ number_format($add = $item->diff * (1 + $item->acc / 100) * (1 + $item->cost / 100) * (1 + $item->risk / 100)) }}
                                    </td>
                                    <td class="text-end">{{ number_format($total = $add * $item->effort) }}</td>
                                </tr>
                                @php
                                    $all += $total;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td rowspan="3" class="align-top"><small>{!! nl2br($estimate->memo) !!}</small></td>
                                <td colspan="2" class="fw-bold text-center">小計</td>
                                <td class="text-end">￥{{ number_format($all) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold text-center">消費税</td>
                                <td class="text-end">￥{{ number_format($all * 0.1) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold text-center">合計</td>
                                <td class="text-end fs-4" id="grand_total">￥{{ number_format($all * 1.1) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="logo-estimate">EstiMeister</div>
            </div>

        </div>
        <div class="mt-5 row d-print-none">
            <div class="col-3 offset-3 d-grid">
                <a href="{{ route('estimates.index') }}" class="btn btn-secondary btn-lg">見積一覧</a>
            </div>
            <div class="col-3 d-grid">
                <a href="{{ route('estimate.edit', $estimate->id) }}" class="btn btn-primary btn-lg">この見積を編集</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            const total = $("#grand_total").html();
            $("#total").text(total);
        })

        function changeVersion() {
            var version = document.getElementById('versionSelect').value;
            var estimateId = {{ $estimate->id }};
            window.location.href = '/estimates/' + estimateId + '/version/' + version;
        }
    </script>
@endsection
