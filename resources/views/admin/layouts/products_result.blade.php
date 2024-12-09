@foreach ($products as $product)
    <div class="product-item border p-3 mb-2">
        <h5>{{ $product->name }}</h5>
        <p><strong>SKU:</strong> {{ $product->sku }}</p>
        <p><strong>Описание:</strong> {{ $product->description ?? 'Нет описания' }}</p>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100" />
        @endif
    </div>
@endforeach

