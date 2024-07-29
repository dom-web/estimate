@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <h1 class="mb-4">顧客新規追加</h1>
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="name" class="col-2">顧客名</label>
                        <div class="col-8 col-md-5">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="kana" class="col-2">フリガナ</label>
                        <div class="col-8 col-md-5">
                        <input type="text" class="form-control" id="kana" name="kana" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="zip" class="col-2">郵便番号</label>
                        <div class="col-2">
                        <input type="text" class="form-control" id="zip" name="zip" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="address" class="col-2">住所</label>
                        <div class="col-10">
                        <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="tel" class="col-2">電話番号</label>
                        <div class="col-3">
                        <input type="text" class="form-control" id="tel" name="tel" required>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="memo" class="col-2">メモ</label>
                        <div class="col-10">
                        <textarea class="form-control" id="memo" name="memo"></textarea>
                        </div>
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-primary btn-lg">追加</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#zip').on('input', function() {
                var zip = $(this).val().replace('-', '');
                if (zip.length === 7) {
                    $.ajax({
                        url: 'https://zipcloud.ibsnet.co.jp/api/search',
                        dataType: 'jsonp',
                        data: { zipcode: zip },
                        success: function(data) {
                            if (data.results) {
                                var result = data.results[0];
                                var address = result.address1 + result.address2 + result.address3;
                                $('#address').val(address);
                            } else {
                                alert('郵便番号に対応する住所が見つかりませんでした。');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
