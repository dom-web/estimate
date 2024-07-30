<option value="">Select Item</option>
@foreach ($items as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
@endforeach
