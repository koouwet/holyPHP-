<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Хранилище вещей')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav a { margin-right: 12px; }
        .flash { padding: 10px; background: #eef; border: 1px solid #ccd; margin: 10px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f3f3; }

        .dropdown { position: relative; cursor: pointer; }
        .dropdown-menu {
            display: none;
            position: absolute;
            left: 0;
            top: 18px;
            background: #fff;
            border: 1px solid #ccc;
            padding: 4px 8px;
            z-index: 100;
        }
        .dropdown:hover .dropdown-menu { display: block; }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('home') }}">Главная</a>

    @auth
        <span class="dropdown">
            <span>Вещи ▾</span>
            <span class="dropdown-menu">
                <a href="{{ route('things.filter.my') }}">My things</a><br>
                <a href="{{ route('things.filter.repair') }}">Repair things</a><br>
                <a href="{{ route('things.filter.work') }}">Work</a><br>
                <a href="{{ route('things.filter.used') }}">Used things</a><br>
                <a href="{{ route('things.filter.all') }}">All things</a>
            </span>
        </span>

        <a href="{{ route('places.index') }}">Места</a>
        <a href="{{ route('usages.index') }}">Выдачи</a>
        <a href="{{ route('things.archive') }}">Архив</a>

        <span>Привет, {{ auth()->user()->name }}</span>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Выйти</button>
        </form>
    @endauth

    @guest
        <a href="{{ route('login') }}">Вход</a>
        <a href="{{ route('register') }}">Регистрация</a>
    @endguest
</nav>

@if (session('status'))
    <div class="flash">{{ session('status') }}</div>
@endif

@yield('content')

</body>
</html>
