@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <h1>Регистрация</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf

        <div>
            <label>Имя</label><br>
            <input type="text" name="name" required value="{{ old('name') }}">
        </div>

        <div>
            <label>Email</label><br>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div>
            <label>Пароль</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <p>
        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
    </p>
@endsection
