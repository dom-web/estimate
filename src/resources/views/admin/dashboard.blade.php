@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold text-primary mb-4">初期値設定</h2>
                <p class="lead mb-4">アイテム作成時の各種単価、予備費の初期値を設定します。
                </p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ isset($defaults) ? route('admin.update') : route('admin.store') }}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_low" class="form-label">低難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_low"
                                            name="diff_low" value="{{ $defaults->diff_low ?? '' }}" required></div>
                                    <span class="col-2 te">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_mid" class="form-label">中難易度単価</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="diff_mid"
                                            name="diff_mid" value="{{ $defaults->diff_mid ?? '' }}" required></div>
                                    <span class="col-2">円</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diff_high" class="form-label">高難易度単価</label>
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
                            <div cl mb-4bel for="acc_low" class="form-label">低精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_low"
                                            name="acc_low" value="{{ $defaults->acc_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_mid" class="form-label">中精度予備費</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="acc_mid"
                                            name="acc_mid" value="{{ $defaults->acc_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="acc_high" class="form-label">高精度予備費</label>
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
                                <label for="cost_low" class="form-label">短期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_low"
                                            name="cost_low" value="{{ $defaults->cost_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_mid" class="form-label">中期コスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="cost_mid"
                                            name="cost_mid" value="{{ $defaults->cost_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cost_high" class="form-label">長期コスト</label>
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
                                <label for="risk_low" class="form-label">低リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_low"
                                            name="risk_low" value="{{ $defaults->risk_low ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_mid" class="form-label">中リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_mid"
                                            name="risk_mid" value="{{ $defaults->risk_mid ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="risk_high" class="form-label">高リスクコスト</label>
                                <div class="row g-1 align-items-center">
                                    <div class="col-10"><input type="number" class="form-control" id="risk_high"
                                            name="risk_high" value="{{ $defaults->risk_high ?? '' }}" required></div>
                                    <span class="col-2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            {{ isset($defaults) ? __('設定保存') : __('Create Defaults') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
