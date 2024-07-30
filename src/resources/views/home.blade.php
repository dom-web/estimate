@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('estimate.store') }}">
                    @csrf
                    <div>
                        <label for="name">件名</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div>
                        <label for="customer_id">お客様</label>
                        <select name="customer_id" id="customer_id" class="form-select">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="person">部署／担当者</label>
                        <input type="text" id="person" name="person" class="form-control" required>
                    </div>
                    <div>
                        <label for="issue_date">発行日</label>
                        <input type="date" id="issue_date" name="issue_date" class="form-control" required>
                    </div>
                    <div>
                        <label for="limit_date">有効期限</label>
                        <input type="date" id="limit_date" name="limit_date" class="form-control" required>
                    </div>
                    <div>
                        <label for="memo">Memo:</label>
                        <textarea id="memo" name="memo" class="form-control"></textarea>
                    </div>
                    <div>
                        <input type="hidden" id="user_id" name="user_id" required value="{{ Auth::user()->id }}">
                    </div>
                    <div id="items-container"></div>
                    <button type="button" id="add-item" hx-get="/item-box" hx-trigger="click" hx-target="#items-container"
                        hx-swap="beforeend">Add Item</button>

                        <div id="summary">
                            <div id="subtotal">小計: 0円</div>
                            <div id="tax">消費税: 0円</div>
                            <div id="total">合計: 0円</div>
                        </div>
                    <button type="submit">Create Estimate</button>
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
            if (evt.detail.target.classList.contains('item-select')) {
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
        $('#item-container .item-box').each(function() {
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
            updateOverallTotal();
        });

        item.find('.remove-button').on('click', function() {
            item.remove();
            updateOverallTotal();
        });
    }

    // 初期アイテムにイベントリスナーを追加
    $('#item-container').find('.item-box').each(function() {
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
@endsection;
