<div class="item-box card mt-4">
    <div class="card-body">
        <select class="item-select form-select" name="id" hx-get="/item-get" hx-trigger="change" hx-target="this" hx-swap="outerHTML">
            <option value="">Select Item</option>
            @foreach ($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>
