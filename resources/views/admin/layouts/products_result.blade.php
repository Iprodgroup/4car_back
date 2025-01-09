@if($products->count() > 0)
    <div class="card" style="height: 600px; width: 600px; position: absolute; top: 50px">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Изображение</th>
                    <th>Артикул</th>
                    <th>Название</th>
                    <th>Цена</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image }}"
                                 alt="{{ $product->name }}"
                                 style="max-width: 50px; max-height: 50px;">
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="alert alert-warning">Товары не найдены</div>
@endif
