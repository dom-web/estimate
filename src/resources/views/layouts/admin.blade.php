<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EstiMeister') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
    <link rel="icon" href="{{asset('/img/logo-w.svg')}}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="body-admin">
    <div id="app" class="wrap">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid h-100">
            <div class="row h-100">
                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                    <h1 class="mt-3 "><a href="{{ url('/') }}" class="d-flex align-items-center"><i style="display: block; width: 2rem;" class="me-2"><img src="{{asset('/img/logo-w.svg')}}" alt="" class="img-fluid"></i>EstiMeister</a></h1>
                    <div class="position-sticky pt-md-5">
                        @php
                        $routeName = Route::currentRouteName();
                        @endphp
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2">
                                <a class="nav-link{{$routeName==='admin.dashboard'?' active' : ''}}" aria-current="page" href="{{ url('/admin/') }}">
                                    <span class="ml-2">初期値設定</span>
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ url('/admin/customers') }}">
                                    <span class="ml-2">顧客管理</span>
                                </a>
                                <ul class="ps-3">
                                    <li><a href="{{ url('/admin/customers') }}" class="nav-sub{{$routeName==='customers.index'?' active' : ''}}">顧客一覧</a></li>
                                    <li><a href="{{ url('/admin/customers/create') }}" class="nav-sub{{$routeName==='customers.create'?' active' : ''}}">顧客追加</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ url('/admin/items') }}">
                                    <span class="ml-2">アイテム管理</span>
                                </a>
                                <ul class="ps-3">
                                    <li><a href="{{ url('/admin/items') }}" class="nav-sub{{$routeName==='items.index'?' active' : ''}}">アイテム一覧</a></li>
                                    <li><a href="{{ url('/admin/items/create') }}" class="nav-sub{{$routeName==='items.create'?' active' : ''}}">アイテム追加</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ url('/admin/users') }}">
                                    <span class="ml-2">ユーザ管理</span>
                                </a>
                                <ul class="ps-3">
                                    <li><a href="{{ url('/admin/users') }}" class="nav-sub{{$routeName==='users.index'?' active' : ''}}">ユーザ一覧</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link{{$routeName==='estimates.charts'?' active' : ''}}" href="{{ url('/admin/charts') }}">
                                    <span class="ml-2">営業データ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="admin_main col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
