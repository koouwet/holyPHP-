@extends('layouts.app')

@section('title', 'Добавить место')

@section('content')
    <h1>Добавить место</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('places.store') }}">
        @csrf

        <div>
            <label>Название</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Описание</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>
                <input type="checkbox" name="repair" value="1" {{ old('repair') ? 'checked' : '' }}>
                Это ремонт / мойка
            </label>
        </div>

        <div>
            <label>
                <input type="checkbox" name="work" value="1" {{ old('work') ? 'checked' : '' }}>
                Место сейчас в работе
            </label>
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
