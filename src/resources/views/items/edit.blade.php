@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold text-primary mb-4">アイテム編集</h2>
                <form method="POST" action="{{ route('items.update', $item->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row align-items-center mb-4">
                        <label for="name" class="col-lg-2 col-sm-3">アイテム名</label>
                        <div class="col-lg-4 col-sm-5"><input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}"></div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <label for="category" class="col-lg-2 col-sm-3">カテゴリー</label>
                        <div class="col-lg-4 col-sm-5">
                            <select name="category" class="form-select">
                                <option value=""></option>
                                <option value="1" {{ $item->category == 1 ? 'selected' : '' }}>プロジェクト計画</option>
                                <option value="2" {{ $item->category == 2 ? 'selected' : '' }}>デザイン</option>
                                <option value="3" {{ $item->category == 3 ? 'selected' : '' }}>フロントエンド開発</option>
                                <option value="4" {{ $item->category == 4 ? 'selected' : '' }}>バックエンド開発</option>
                                <option value="5" {{ $item->category == 5 ? 'selected' : '' }}>インフラストラクチャ</option>
                                <option value="6" {{ $item->category == 6 ? 'selected' : '' }}>コンテンツ作成</option>
                                <option value="7" {{ $item->category == 7 ? 'selected' : '' }}>テスト</option>
                                <option value="8" {{ $item->category == 8 ? 'selected' : '' }}>デプロイメント</option>
                                <option value="9" {{ $item->category == 9 ? 'selected' : '' }}>保守・運用</option>
                                <option value="10" {{ $item->category == 10 ? 'selected' : '' }}>ドキュメント</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_low">低難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_low" name="diff_low" value="{{ old('diff_low', $item->diff_low) }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_mid">中難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_mid" name="diff_mid" value="{{ old('diff_mid', $item->diff_mid) }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_high">高難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_high" name="diff_high" value="{{ old('diff_high', $item->diff_high) }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_low">低精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_low" name="acc_low" value="{{ old('acc_low', $item->acc_low) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_mid">中精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_mid" name="acc_mid" value="{{ old('acc_mid', $item->acc_mid) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_high">高精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_high" name="acc_high" value="{{ old('acc_high', $item->acc_high) }}" required></div>
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
                                    <div class="col-10"><input type="number" class="form-control" id="cost_low" name="cost_low" value="{{ old('cost_low', $item->cost_low) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_mid">中期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_mid" name="cost_mid" value="{{ old('cost_mid', $item->cost_mid) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_high">長期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_high" name="cost_high" value="{{ old('cost_high', $item->cost_high) }}" required></div>
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
                                    <div class="col-10"><input type="number" class="form-control" id="risk_low" name="risk_low" value="{{ old('risk_low', $item->risk_low) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_mid">中リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_mid" name="risk_mid" value="{{ old('risk_mid', $item->risk_mid) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_high">高リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_high" name="risk_high" value="{{ old('risk_high', $item->risk_high) }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="memo" class="col-lg-2 col-sm-3">メモ</label>
                        <div class="col-lg-10 col-sm-9">
                            <textarea name="memo" rows="5" class="form-control">{{ old('memo', $item->memo) }}</textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-5">
                        <input type="reset" value="リセット" class="btn btn-secondary btn-lg col-lg-2 col-4">
                        <input type="submit" value="更新" class="btn btn-primary btn-lg col-lg-2 col-4 ms-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
