<input type="hidden" class="item-input" data-name="item_id" value="{{ $selected->id }}">
<div class="row align-items-center mb-4">
    <h5 class="col-md-7 mb-0">{{ $selected->name }}</h5>
    <div class="col-md-2"><input type="number" min="0" class="item-input form-control" data-name="effort" value="0"></div>
    <div class="col-md-3 fs-3 fw-bold text-end">￥<span class="item_total">0</span></div>
</div>
<div class="row">
    <div class="col-md-3">
        <select class="item-input form-select" data-name="diff">
            <option value="{{ $selected->diff_low }}">低難易度（{{ $selected->diff_low }}円）</option>
            <option value="{{ $selected->diff_mid }}" selected>中難易度（{{ $selected->diff_mid }}円）</option>
            <option value="{{ $selected->diff_high }}">高難易度（{{ $selected->diff_high }}円）</option>
        </select>

    </div>
    <div class="col-md-3">
        <select class="item-input form-select" data-name="acc">
            <option value="{{ $selected->acc_low }}">低精度（{{ $selected->acc_low }}％）</option>
            <option value="{{ $selected->acc_mid }}">中精度（{{ $selected->acc_mid }}％）</option>
            <option value="{{ $selected->acc_high }}" selected>高精度（{{ $selected->acc_high }}％）</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="item-input form-select" data-name="cost">
            <option value="{{ $selected->cost_low }}" selected>短期（{{ $selected->cost_low }}％）</option>
            <option value="{{ $selected->cost_mid }}">中期（{{ $selected->cost_mid }}％）</option>
            <option value="{{ $selected->cost_high }}">長期（{{ $selected->cost_high }}％）</option>
        </select>
    </div>
    <div class="col-md-3">
        <select class="item-input form-select" data-name="risk">
            <option value="{{ $selected->risk_low }}" selected>低リスク（{{ $selected->risk_low }}％）</option>
            <option value="{{ $selected->risk_mid }}">中リスク（{{ $selected->risk_mid }}％）</option>
            <option value="{{ $selected->risk_high }}">高リスク（{{ $selected->risk_high }}％）</option>
        </select>
    </div>
</div>
<button class="remove-button btn-close" aria-label="Close"></button>
