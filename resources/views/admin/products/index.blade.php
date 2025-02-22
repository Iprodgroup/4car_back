<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>4CAR</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/js/config.js')}}"></script>
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @extends('admin.layouts.aslide')
        <div class="layout-page">
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" id="search-sku" class="form-control border-0 shadow-none" placeholder="Search by SKU..." aria-label="Search by SKU" />
                        </div>
                    </div>
                    <div id="search-results" class="mt-2 w-100"></div>
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="#" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Мой профиль </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle"> Выйти </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Товары</h4>
                    <a type="button" class="btn btn-primary" href="{{ route('admin.products.create') }}">
                        <span class="tf-icons bx "></span>&nbsp; Создать
                    </a>
                    <br><br>
                    <div class="card">
                        <h5 class="card-header">Товары</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Изображение</th>
                                    <th>Артикул</th>
                                    <th>Наименование</th>
                                    <th>Цена</th>
                                    <th>Кол-во на складе</th>
                                    <th>Изменить</th>
                                    <th>Удалить</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="product-table">
                                @foreach($products as $product)
                                    <tr>
                                        <td><img src="{{ $product->image }}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stock_quantity }}</td>
                                        <td><a type="button" href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Изменить</a></td>
                                        <td>
                                            <form action="{{ route('admin.products.delete', $product->id) }}" method="post" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            <footer class="content-footer footer bg-footer-theme"></footer>
            <div class="content-backdrop fade"></div>
        </div>
    </div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
@extends('admin.layouts.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let debounceTimeout;

        $('#search-sku').on('input', function () {
            clearTimeout(debounceTimeout);
            let sku = $(this).val();

            debounceTimeout = setTimeout(function() {
                if (sku.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.products.search') }}",
                        method: "GET",
                        data: { sku: sku },
                        success: function (response) {
                            if (response.success) {
                                let products = response.products;
                                let tableContent = '';

                                products.forEach(product => {
                                    tableContent += `
                                        <tr>
                                            <td><img src="${product.image}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                                            <td>${product.sku}</td>
                                            <td>${product.name}</td>
                                            <td>${product.price}</td>
                                            <td>${product.stock_quantity}</td>
                                            <td><a type="button" href="/products/edit/${product.id}" class="btn btn-primary">Изменить</a></td>
                                            <td>
                                                <form action="/products/delete/${product.id}" method="post" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
`;
                                });

                                $('#product-table').html(tableContent);
                            } else {
                                $('#product-table').html('<tr><td colspan="7">Товары не найдены</td></tr>');
                            }
                        },
                        error: function () {
                            $('#product-table').html('<tr><td colspan="7">Ошибка выполнения поиска</td></tr>');
                        }
                    });
                } else {
                    location.reload();  // Перезагрузка страницы, если поле пустое
                }
            }, 300);  // 300ms задержка перед отправкой запроса
        });
    });
</script>
</body>
</html>
