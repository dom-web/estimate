@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form method="POST" action="{{ route('estimate.update', $estimate->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="checkbox" name="issued" id="issued" value="1">
                    <label for="issued">発行済</label>
                    <div class="row align-items-center mb-4">
                        <label for="customer_id" class="col-md-2">お客様</label>
                        <div class="col-md-4">
                            {{ $customer->name }}
                            <input type="hidden" name="customer_id" value="{{$estimate->customer_id}}">
                        </div>
                        <label for="person" class="col-md-2">部署／担当者</label>
                        <div class="col-md-4"><input type="text" id="person" name="person" class="form-control"
                                required value="{{ $estimate->person }}"></div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <label for="issue_date" class="col-md-2">発行日</label>
                        <div class="col-md-4"><input type="date" id="issue_date" name="issue_date" class="form-control"
                                required value="{{ $estimate->issue_date }}"></div>
                        <label for="limit_date" class="col-md-2">有効期限</label>
                        <div class="col-md-4"><input type="date" id="limit_date" name="limit_date" class="form-control"
                                required value="{{ $estimate->limit_date->format('Y-m-d') }}"></div>
                    </div>
                    <div class="row align-items-center">
                        <label for="name" class="col-2">件名</label>
                        <div class="col-10"><input type="text" class="form-control" id="name" name="name"
                                required value="{{ $estimate->name }}"></div>
                    </div>

                    <div id="items-container">
                        @foreach ($items as $item)
                        <div class="item-box card mt-4">
                            <div class="card-body">
                                <input type="hidden" class="item-input" data-name="item_id" value="{{$item->item_id}}">
                                <div class="row align-items-center mb-4">
                                    <h5 class="col-md-7 mb-0">{{$item-> item -> name}}</h5>
                                    <div class="col-md-2"><input type="number" class="item-input form-control"
                                            data-name="effort" value="{{$item->effort}}"></div>
                                    <div class="col-md-3 fs-3 fw-bold text-end">￥<span class="item_total">{{$item-> diff * (1 + $item -> acc / 100) * (1 + $item -> cost / 100) * (1 + $item -> risk / 100) * $item->effort}}</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="item-input form-select" data-name="diff">
                                            <option value="{{$item->item->diff_low}}"{{$item -> diff == $item->item->diff_low ? ' selected' : ''}}>低難易度（{{$item->item->diff_low}}円）</option>
                                            <option value="{{$item->item->diff_mid}}"{{$item -> diff == $item->item->diff_mid ? ' selected' : ''}}>中難易度（{{$item->item->diff_mid}}円）</option>
                                            <option value="{{$item->item->diff_high}}"{{$item -> diff == $item->item->diff_high ? ' selected' : ''}}>高難易度（{{$item->item->diff_high}}円）</option>
                                        </select>

                                    </div>
                                    <div class="col-md-3">
                                        <select class="item-input form-select" data-name="acc">
                                            <option value="{{$item->item->acc_low}}"{{$item -> acc == $item->item->acc_low ? ' selected' : ''}}>低精度（{{$item->item->acc_low}}％）</option>
                                            <option value="{{$item->item->acc_mid}}"{{$item -> acc == $item->item->acc_mid ? ' selected' : ''}}>中精度（{{$item->item->acc_mid}}％）</option>
                                            <option value="{{$item->item->acc_high}}"{{$item -> acc == $item->item->acc_high ? ' selected' : ''}}>高精度（{{$item->item->acc_high}}％）</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="item-input form-select" data-name="cost">
                                            <option value="{{$item->item->cost_low}}"{{$item -> cost == $item->item->cost_low ? ' selected' : ""}}>短期（{{$item->item->cost_low}}％）</option>
                                            <option value="{{$item->item->cost_mid}}"{{$item -> cost == $item->item->cost_mid ? ' selected' : ""}}>中期（{{$item->item->cost_mid}}％）</option>
                                            <option value="{{$item->item->cost_high}}{{$item -> cost == $item->item->cost_high ? ' selected' : ""}}">長期（{{$item->item->cost_high}}％）</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="item-input form-select" data-name="risk">
                                            <option value="{{$item->item->risk_low}}"{{$item -> risk == $item->item->risk_low ? ' selected' : ""}}>低リスク（{{$item->item->risk_low}}％）</option>
                                            <option value="{{$item->item->risk_mid}}"{{$item -> risk == $item->item->risk_mid ? ' selected' : ""}}>中リスク（{{$item->item->risk_mid}}％）</option>
                                            <option value="{{$item->item->risk_high}}"{{$item -> risk == $item->item->risk_high ? ' selected' : ""}}>高リスク（{{$item->item->risk_high}}％）</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="remove-button btn-close" aria-label="Close"></button>

                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center my-4">
                        <button type="button" id="add-item" hx-get="/item-box" hx-trigger="click"
                            hx-target="#items-container" hx-swap="beforeend" class="btn btn-sm btn-secondary">+</button>
                    </div>

                    <div>
                        <label for="memo">Memo:</label>
                        <textarea id="memo" name="memo" class="form-control">{{ $estimate->memo }}</textarea>
                    </div>
                    <div>
                        <input type="hidden" id="user_id" name="user_id" required value="{{ Auth::user()->id }}">
                    </div>
                    <div id="summary">
                        <div id="subtotal">小計: 0円</div>
                        <div id="tax">消費税: 0円</div>
                        <div id="total">合計: 0円</div>
                    </div>
                    <a href="{{ url('/estimate-list') }}" class="btn btn-secondary">見積一覧</a>
                    <button type="submit" class="btn btn-primary">編集</button>
                </form>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let itemCount = 0;

        document.addEventListener('htmx:afterSwap', function(evt) {
            if (evt.detail.target.classList.contains('row')) {
                updateIndices();
            }
        });

        document.addEventListener('click', function(evt) {
            if (evt.target.classList.contains('remove-button')) {
                const itemBox = evt.target.closest('.item-box');
                itemBox.remove();
                updateIndices();
            }
        });

        function updateIndices() {
            const itemBoxes = document.querySelectorAll('.item-box');
            itemBoxes.forEach((box, idx) => {
                box.dataset.index = idx;
                //box.querySelector('.item-number').textContent = idx;

                const inputs = box.querySelectorAll('.item-input, .item-select');
                inputs.forEach(input => {
                    const name = input.dataset.name || input.name;
                    input.name = `items[${idx}][${name}]`;
                    //input.dataset.index = idx;
                });
            });
            itemCount = itemBoxes.length;
        }

        $(document).ready(function() {
            updateIndices();
            updateOverallTotal();
            function calculateTotal(item) {
                // 必要な値を取得
                var effort = parseFloat(item.find('input[data-name="effort"]').val()) || 0;
                var diff = parseFloat(item.find('select[data-name="diff"]').val()) || 0;
                var acc = parseFloat(item.find('select[data-name="acc"]').val()) || 0;
                var cost = parseFloat(item.find('select[data-name="cost"]').val()) || 0;
                var risk = parseFloat(item.find('select[data-name="risk"]').val()) || 0;

                // 計算
                var base = diff * effort;
                var total = base * (1 + acc / 100) * (1 + cost / 100) * (1 + risk / 100);

                // 小数点以下を切り上げ
                total = Math.ceil(total);

                // 結果を表示
                item.find('.item_total').text(total);

                // 全体の合計を更新
                updateOverallTotal();
            }

            function updateOverallTotal() {
                var subtotal = 0;
                $('#items-container .item-box').each(function() {
                    var itemTotalText = $(this).find('.item_total').text();
                    var itemTotal = parseFloat(itemTotalText) || 0;
                    subtotal += itemTotal;
                });

                var tax = Math.ceil(subtotal * 0.1); // 消費税は10%
                var total = subtotal + tax;

                $('#subtotal').text('小計: ' + subtotal + '円');
                $('#tax').text('消費税: ' + tax + '円');
                $('#total').text('合計: ' + total + '円');
            }

            function addEventListeners(item) {
                // item は .item-box 要素
                item.find('.item-input, .item-select').on('change', function() {
                    calculateTotal(item);

                });

                item.find('.remove-button').on('click', function() {
                    item.remove();
                    updateOverallTotal();
                });
            }

            // 初期アイテムにイベントリスナーを追加
            $('#items-container').find('.item-box').each(function() {
                addEventListeners($(this));
            });

            // select要素のchangeイベントをトリガーにイベントリスナーを追加
            $(document).on('change', '.item-select', function() {
                var itemBox = $(this).closest('.item-box');
                addEventListeners(itemBox);
            });

            // アイテムが追加されたときにイベントリスナーを追加
            $(document).on('htmx:afterOnLoad', function(evt) {
                var newElement = $(evt.target).closest('.item-box');
                if (newElement.length) {
                    addEventListeners(newElement);
                }
            });
        });
    </script>
@endsection
