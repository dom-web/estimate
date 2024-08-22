@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold text-primary mb-4">アイテム追加</h2>
                <form method="POST" action="{{ route('items.store') }}">
                    @csrf
                    <div class="row align-items-center mb-4">
                        <label for="name" class="col-lg-2 col-sm-3">アイテム名</label>
                        <div class="col-lg-4 col-sm-5"><input type="text" class="form-control" name="name"></div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <label for="name" class="col-lg-2 col-sm-3">カテゴリー</label>
                        <div class="col-lg-4 col-sm-5">
                            <select name="category" class="form-select">
                                <option value=""></option>
                                <option value="1">プロジェクト計画</option>
                                <option value="2">デザイン</option>
                                <option value="3">フロントエンド開発</option>
                                <option value="4">バックエンド開発</option>
                                <option value="5">インフラストラクチャ</option>
                                <option value="6">コンテンツ作成</option>
                                <option value="7">テスト</option>
                                <option value="8">デプロイメント</option>
                                <option value="9">保守・運用</option>
                                <option value="10">ドキュメント</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_low">低難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_low"
                                            name="diff_low" value="{{ $defaults->diff_low ?? '' }}" required></div>
                                    <span class="col-2 te">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_mid">中難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_mid"
                                            name="diff_mid" value="{{ $defaults->diff_mid ?? '' }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_high">高難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_high"
                                            name="diff_high" value="{{ $defaults->diff_high ?? '' }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div cl mb-4bel for="acc_low">低精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_low"
                                            name="acc_low" value="{{ $defaults->acc_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_mid">中精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_mid"
                                            name="acc_mid" value="{{ $defaults->acc_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_high">高精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_high"
                                            name="acc_high" value="{{ $defaults->acc_high ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_low">短期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_low"
                                            name="cost_low" value="{{ $defaults->cost_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_mid">中期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_mid"
                                            name="cost_mid" value="{{ $defaults->cost_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_high">長期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_high"
                                            name="cost_high" value="{{ $defaults->cost_high ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_low">低リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_low"
                                            name="risk_low" value="{{ $defaults->risk_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_mid">中リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_mid"
                                            name="risk_mid" value="{{ $defaults->risk_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_high">高リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_high"
                                            name="risk_high" value="{{ $defaults->risk_high ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="memo" class="col-lg-2 col-sm-3">メモ</label>
                        <div class="col-lg-10 col-sm-9">
                            <textarea name="memo" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5">
                        <input type="reset" value="リセット" class="btn btn-secondary btn-lg col-lg-2 col-4">
                        <input type="submit" value="登録" class="btn btn-primary btn-lg col-lg-2 col-4 ms-4">
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
