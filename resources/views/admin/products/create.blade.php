
<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>4CAR</title>

    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.ico')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />
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
            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar"
            >
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input
                            type="text"
                            class="form-control border-0 shadow-none"
                            placeholder="Поиск по артикулу"
                            aria-label="Поиск по артикулу"
                        />
                    </div>
                </div>
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

                    <div class="card">
                        <h5 class="card-header">Создать товар </h5>
                        <form class="card-body" method="post" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Sku</label>
                                <input type="text" class="form-control" name="sku" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Цена</label>
                                <input type="text" class="form-control" name="price" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Название</label>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Категория</label>
                                <input type="text" class="form-control" name="vidy_nomenklaturi" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Бренд</label>
                                <input type="text" class="form-control" name="brendy" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="characteristics" class="form-label">Run Flat</label>
                                <input class="form-control" name="run_flat" id="characteristics">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Ширина</label>
                                <input type="text" class="form-control" name="weight" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Модель</label>
                                <input type="text" class="form-control" name="modeli" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Сезонность</label>
                                <input type="text" class="form-control" name="sezony" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Шипы</label>
                                <input type="text" class="form-control" name="shipy" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Высота шин</label>
                                <input type="text" class="form-control" name="vysota_shin" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Диаметр шин</label>
                                <input type="text" class="form-control" name="diametr_shin" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Индекс скорости</label>
                                <input type="text" class="form-control" name="indeks_skorosti" id="exampleFormControlInput1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Диаметр шин</label>
                                <input type="text" class="form-control" name="indeks_nagruzki" id="exampleFormControlInput1" >
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input class="form-control" type="file" id="formFile" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="content-footer footer bg-footer-theme">

            </footer>

            <div class="content-backdrop fade"></div>
        </div>
    </div>
</div>

<div class="layout-overlay layout-menu-toggle"></div>
@extends('admin.layouts.footer')
</body>
</html>

