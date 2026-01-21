@extends('layouts.app')

@section('title', 'Редактировать место')

@section('content')
    <h1>Редактировать место</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('places.update', $place) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Название</label><br>
            <input type="text" name="name" value="{{ old('name', $place->name) }}" required>
        </div>

        <div>
            <label>Описание</label><br>
            <textarea name="description">{{ old('description', $place->description) }}</textarea>
        </div>

        <div>
            <label>
                <input type="checkbox" name="repair" value="1" {{ old('repair', $place->repair) ? 'checked' : '' }}>
                Это ремонт / мойка
            </label>
        </div>

        <div>
            <label>
                <input type="checkbox" name="work" value="1" {{ old('work', $place->work) ? 'checked' : '' }}>
                Место сейчас в работе
            </label>
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
