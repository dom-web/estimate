@extends('layouts.app')
@section('content')
    <div class="container-lg">

        <div class="d-md-flex justify-content-between align-items-start d-print-none mb-4">

            <div class="d-grid col-md-3 mb-3">
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
                <select id="versionSelect" onchange="changeVersion()" class="form-select mb-4">
                    @foreach ($estimate->items->groupBy('version') as $vs)
                        <option value="{{ $vs[0]->version }}" {{ $vs[0]->version == $version ? 'selected' : '' }}>
                            {{ $vs[0]->updated_at->format('Y年m月d日 H:i') }}
                        </option>
                    @endforeach
                </select>
                <button onclick="window.print(); return false;"
                    class="d-print-none btn btn-primary btn-lg mt-mb-3">印刷する</button>
            </div>
            <div class="d-grid col-md-3">
                <label for="invoice-date">支払期限(デフォルトは翌月末に設定)</label>
                <input type="date" id="invoice-date" class="form-control mb-2"
                    value="{{ date('Y-m-d', strtotime('last day of next month')) }}">
                <label for="payee">振込先</label>
                <textarea id="payee" class="form-control mb-2">楽天銀行ダンス支店&#13;普通 0000000</textarea>
                <button class="btn btn-success btn-lg" data-text="この見積で請求書を作る">この見積で請求書を作る</button>
            </div>

        </div>
        <div class="card">
            <div class="card-body">
                @if(isset($items[0]))
                <div class="text-end date-today" data-text="{{ $items[0]->updated_at->format('Y年m月d日') }}">
                    {{ $items[0]->updated_at->format('Y年m月d日') }}</div>
                @endif
                <div class="text-end">
                    <span
                        class="number">見積番号</span>：{{ sprintf('%03d', $customer->id) }}-{{ sprintf('%03d', $estimate->id) }}-{{ sprintf('%03d', $items[0]->version) }}
                </div>

                <h1 class="text-center fw-bold my-3 hdg">見積書</h1>
                <div class="row mb-5">
                    <div class="col-lg-3 col-5">
                        <h3>{{ $customer->name }} <small>御中</small></h3>
                        <h4 class="fs-5 mb-3">{{ $estimate->person }} <small>様</small></h4>
                        <div>件名：{{ $estimate->name }}</div>
                        <p class="invoice-date" data-text="有効期限：{{ $estimate->limit_date->format('Y年m月d日') }}">
                            有効期限：{{ $estimate->limit_date->format('Y年m月d日') }}</p>
                        <p class="txt-price">下記のとおりお見積申し上げます。</p>
                        <div class="price d-flex justify-content-between align-items-baseline border-bottom">
                            <small class="ttl-price">お見積金額</small>
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
                    <table class="table table-bordered table-estimate">
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
                            @if($items)
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
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td rowspan="3" class="align-top"><small class="text-memo"
                                        data-text="{!! nl2br($estimate->memo) !!}">{!! nl2br($estimate->memo) !!}</small></td>
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
            <div class="col-3 offset-2 d-grid">
                <a href="{{ route('estimates.index') }}" class="btn btn-secondary btn-lg">見積一覧</a>
            </div>
            <div class="col-3 d-grid">
                <a href="{{ route('estimate.edit', $estimate->id) }}" class="btn btn-primary btn-lg">この見積を編集</a>
            </div>
            <div class="col-2 d-grid">
                <form action="{{ route('estimate.destroy', $estimate->id) }}" method="POST"
                    onsubmit="return confirm('本当に削除しますか？');" class=" d-grid">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-lg" type="submit">削除</button>
                </form>
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


        $.fn.clickToggle = function(a, b) {
            return this.each(function() {
                var clicked = false;
                $(this).on('click', function() {
                    clicked = !clicked;
                    if (clicked) {
                        return a.apply(this, arguments);
                    }
                    return b.apply(this, arguments);
                });
            });
        };

        function formatDate(dt) {
            var y = dt.getFullYear();
            var m = ('00' + (dt.getMonth() + 1)).slice(-2);
            var d = ('00' + dt.getDate()).slice(-2);
            return (y + '年' + m + '月' + d + '日');
        }
        $(function() {
            $('button').clickToggle(function() {
                // １回目のクリック
                $(this).text('見積書にもどす');
                $('.date-today').text(formatDate(new Date()));
                $('.number').text('請求書番号');
                $('.hdg').text('請求書');
                $date = new Date($('#invoice-date').val());
                $('.invoice-date').text('支払期限：' + formatDate($date));
                $('.txt-price').text('下記のとおりご請求申し上げます。');
                $('.ttl-price').text('ご請求金額');
                $('.text-memo').html($('#payee').val().replace(/\n/g, '<br />'));
            }, function() {
                // ２回目のクリック
                $(this).text($(this).data('text'));
                $('.date-today').text($('.date-today').data('text'));
                $('.number').text('見積番号');
                $('.hdg').text('見積書');
                $('.invoice-date').text($('.invoice-date').data('text'));
                $('.txt-price').text('下記のとおりお見積申し上げます。');
                $('.ttl-price').text('お見積金額');
                $('.text-memo').html($('.text-memo').data('text'));
            });

        });

        window.addEventListener("load", () => {
            // (PART A) GET TABLE ROWS, EXCLUDE HEADER ROW
            var all = document.querySelectorAll(".table-estimate tbody tr");

            // (PART B) "CURRENT ROW BEING DRAGGED"
            var dragged;

            // (PART C) DRAG-AND-DROP MECHANISM
            for (let tr of all) {
                // (C1) ROW IS DRAGGABLE
                tr.draggable = true;

                // (C2) ON DRAG START - SET "CURRENTLY DRAGGED" & DATA TRANSFER
                tr.ondragstart = e => {
                    dragged = tr;
                    e.dataTransfer.dropEffect = "move";
                    e.dataTransfer.effectAllowed = "move";
                    e.dataTransfer.setData("text/html", tr.innerHTML);
                };

                // (C3) PREVENT DRAG OVER - NECESSARY FOR DROP TO WORK
                tr.ondragover = e => e.preventDefault();

                // (C4) ON DROP - "SWAP ROWS"
                tr.ondrop = e => {
                    e.preventDefault();
                    if (dragged != tr) {
                        dragged.innerHTML = tr.innerHTML;
                        tr.innerHTML = e.dataTransfer.getData("text/html");
                    }
                };

                // (C5) COSMETICS - HIGHLIGHT ROW "ON DRAG HOVER"
                tr.ondragenter = () => tr.classList.add("hover");
                tr.ondragleave = () => tr.classList.remove("hover");
                tr.ondragend = () => {
                    for (let r of all) {
                        r.classList.remove("hover");
                    }
                };
            }
        });
    </script>
@endsection
