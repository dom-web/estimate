
    <input type="hidden" class="item-input" data-name="item_id" value="{{$selected -> id}}">
    {{$selected -> name}}
    <input type="number" class="item-input form-control" data-name="effort">
    <div class="item_total"></div>
    <select class="item-input form-select" data-name="diff">
        <option value="{{$selected -> diff_low}}">低難易度（{{$selected -> diff_low}}円）</option>
        <option value="{{$selected -> diff_mid}}">中難易度（{{$selected -> diff_mid}}円）</option>
        <option value="{{$selected -> diff_high}}">高難易度（{{$selected -> diff_high}}円）</option>
    </select>
    <select class="item-input form-select" data-name="acc">
        <option value="{{$selected -> acc_low}}">低精度（{{$selected -> acc_low}}％）</option>
        <option value="{{$selected -> acc_mid}}">中精度（{{$selected -> acc_mid}}％）</option>
        <option value="{{$selected -> acc_high}}">高精度（{{$selected -> acc_high}}％）</option>
    </select>
    <select class="item-input form-select" data-name="cost">
        <option value="{{$selected -> cost_low}}">短期（{{$selected -> cost_low}}％）</option>
        <option value="{{$selected -> cost_mid}}">中期（{{$selected -> cost_mid}}％）</option>
        <option value="{{$selected -> cost_high}}">長期（{{$selected -> cost_high}}％）</option>
    </select>
    <select class="item-input form-select" data-name="risk">
        <option value="{{$selected -> risk_low}}">低リスク（{{$selected -> risk_low}}％）</option>
        <option value="{{$selected -> risk_mid}}">中リスク（{{$selected -> risk_mid}}％）</option>
        <option value="{{$selected -> risk_high}}">高リスク（{{$selected -> risk_high}}％）</option>
    </select>

    <button class="remove-button">Remove</button>
