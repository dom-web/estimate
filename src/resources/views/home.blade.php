@extends('layouts.app')

@section('content')
<style>
    .item-box.htmx-added {
        opacity: 0;
        transform: translateX(-2rem);
    }
    .item-box {
        opacity: 1;
        transform: translateX(0);
        transition: 0.2s ease-out;
    }
</style>
    <div class="container h-100">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @endif
                <div class="d-grid gap-2 col-4 mb-4">
                    <a href="{{ url('/estimate-list') }}" class="btn btn-primary btn-lg">見積一覧</a>
                </div>
                <form method="POST" action="{{ route('estimate.store') }}">
                    @csrf
                    <input type="hidden" name="issued" value="0">
                    <input type="hidden" name="ordered" value="0">
                    <input type="hidden" name="on_hold" value="0">
                    <div class="row align-items-center mb-4">
                        <label for="customer_id" class="col-md-2">お客様</label>
                        <div class="col-md-4">
                            <select name="customer_id" id="customer_id" class="form-select">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') === $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="person" class="col-md-2">部署／担当者</label>
                        <div class="col-md-4">
                            <input type="text" id="person" name="person" class="form-control" required value="{{ old('person') }}">

                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <label for="issue_date" class="col-md-2">発行日</label>
                        <div class="col-md-4"><input type="date" id="issue_date" name="issue_date" class="form-control"
                                required value="{{old('issue_date', date('Y-m-d'))}}"></div>
                        <label for="limit_date" class="col-md-2">有効期限</label>
                        <div class="col-md-4"><input type="date" id="limit_date" name="limit_date" class="form-control"
                                required value="{{old('limit_date',date('Y-m-d', strtotime('+30 day')))}}"></div>
                    </div>
                    <div class="row align-items-center">
                        <label for="name" class="col-2">件名</label>
                        <div class="col-10"><input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}"></div>
                    </div>
                    @if ($errors->has('items'))
                        <div class="alert alert-danger mt-4">{{ $errors->first('items') }}</div>
                    @endif
                    <div id="items-container"></div>
                    <div class="text-center my-4">
                        <button type="button" id="add-item" hx-get="/item-box" hx-trigger="click"
                            hx-target="#items-container" hx-swap="beforeend settle:0.1s" class="btn btn-sm btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-5">
                                <label for="memo" class="mb-2">備考・メモ</label>
                                <textarea id="memo" name="memo" class="form-control" rows="4" required>{{old('memo')}}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div id="summary" class="col-4">
                                    <div class="d-flex justify-content-between"><small class="fs-5">小計</small><span
                                            id="subtotal" class="fs-5">0円</span></div>
                                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2"><small
                                            class="fs-5">消費税</small><span id="tax" class="fs-5">0円</span></div>
                                    <div class="d-flex justify-content-between"><small class="fs-4 fw-bold">合計</small><span
                                            id="total" class="fw-bold fs-3">0円</span></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="user_id" name="user_id" required value="{{ Auth::user()->id }}">
                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>


                    <div class="text-center mt-5"><button type="submit" class="btn"><dotlottie-player src="https://lottie.host/beeaad8e-e777-4082-bb33-842cd2ed05fd/qHTRXYk7E8.json" background="transparent" speed="1" style="width: 300px; height: 47px;" hover></dotlottie-player></button></div>
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
                const inputs = box.querySelectorAll('.item-input');
                inputs.forEach(input => {
                    const name = input.dataset.name || input.name;
                    input.name = `items[${idx}][${name}]`;
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
                $('#items-container .item-box').each(function() {
                    var itemTotalText = $(this).find('.item_total').text();
                    var itemTotal = parseFloat(itemTotalText) || 0;
                    subtotal += itemTotal;
                });

                var tax = Math.ceil(subtotal * 0.1); // 消費税は10%
                var total = subtotal + tax;

                $('#subtotal').text(subtotal.toLocaleString() + '円');
                $('#tax').text(tax.toLocaleString() + '円');
                $('#total').text(total.toLocaleString() + '円');
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
@endsection
