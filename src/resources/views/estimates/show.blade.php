@extends('layouts.app')
@section('content')
<div class="container">
    <select id="versionSelect" onchange="changeVersion()">
        @foreach ($estimate->items->groupBy('version')->keys() as $v)
            <option value="{{ $v }}" {{ $v == $version ? 'selected' : '' }}>Version {{ $v }}</option>
        @endforeach
    </select>
    <div class="card">
        <div class="card-body">
            <div class="text-end">{{$estimate->created_at ->format('Y年m月d日')}}</div>
            <div class="text-end">見積番号：{{sprintf('%03d',$customer->id)}}-{{sprintf('%03d',$estimate->id)}}-{{sprintf('%03d',$items[0]->version)}}</div>

            <h1 class="text-center">見積書</h1>
            <div class="row mb-5">
                <div class="col-3">
                    <h3>{{$customer->name}}様</h3>
                    <div>件名：{{$estimate->name}}</div>
                    <p>有効期限：{{$estimate->limit_date -> format('Y年m月d日')}}</p>
                    <p>下記のとおりお見積申し上げます。</p>
                    <div class="price d-flex justify-content-between align-items-baseline border-bottom">
                        <small>お見積金額</small><div class="fs-2 fw-bold"><span id="total"></span></div>
                    </div>
                </div>
                <div class="col-3 offset-6">
                    <p>EstiMeister株式会社</p>
                    <p>〒000-0000<br>
                    愛知県名古屋市中村区名駅1-1-1</p>
                    <p>tel:000-000-0000<br>
                    info@estimeister.com</p>
                </div>
            </div>
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
                        <td>{{$item-> item -> name}}</td>
                        <td class="text-end">{{$item-> effort}}</td>
                        <td class="text-end">{{number_format($add = $item-> diff * (1 + $item -> acc / 100) * (1 + $item -> cost / 100) * (1 + $item -> risk / 100))}}</td>
                        <td class="text-end">{{number_format($total = ($add * $item-> effort))}}</td>
                    </tr>
                        @php
                            $all += $total;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td rowspan="3" class="align-top"><small>{{$estimate->memo}}</small></td>
                        <td colspan="2" class="fw-bold text-center">小計</td>
                        <td class="text-end">￥{{number_format($all)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="fw-bold text-center">消費税</td>
                        <td class="text-end">￥{{number_format($all * 0.1)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="fw-bold text-center">合計</td>
                        <td class="text-end fs-4" id="grand_total">￥{{number_format($all * 1.1)}}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="logo-estimate">EstiMeister</div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function(){
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
