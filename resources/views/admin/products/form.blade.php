<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка XML файла</title>
</head>
<body>
<h1>Загрузка XML файла для обновления продуктов</h1>

@if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.upload.handle') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="file">Выберите XML файл:</label>
        <input type="file" name="file" id="file" required>
    </div>
    <div>
        <button type="submit">Загрузить</button>
    </div>
</form>

<h2>Скачать XML файлы</h2>
<div>
    <form action="{{ route('admin.products.export') }}" method="GET">
        <button type="submit">Скачать XML с продуктами</button>
    </form>
    <form action="{{ route('admin.products.export-with-orders') }}" method="GET">
        <button type="submit">Скачать XML с продуктами и заказами</button>
    </form>
</div>

</body>
</html>
