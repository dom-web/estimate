<div class="item-box card mt-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <select class="item-select form-select form-select-lg" name="id" hx-get="/item-get" hx-trigger="change" hx-target="closest .row" hx-swap="outerHTML">
                    <option value="">Select Item</option>
                    @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="remove-button btn-close" aria-label="Close"></button>
        </div>
    </div>
</div>
