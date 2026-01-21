@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <h1>Вход</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div>
            <label>Email</label><br>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Пароль</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Войти</button>
    </form>

    <p>
        Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a>
    </p>
@endsection
