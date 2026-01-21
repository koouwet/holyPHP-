@extends('layouts.app')

@section('title', 'Редактировать вещь')

@section('content')
    <h1>Редактировать вещь</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('things.update', $thing) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Название</label><br>
            <input type="text" name="name" value="{{ old('name', $thing->name) }}" required>
        </div>

        <div>
            <label>Описание</label><br>
            <textarea name="description">{{ old('description', $thing->description) }}</textarea>
        </div>

        <div>
            <label>Гарантия / срок годности</label><br>
            <input type="date" name="wrnt" value="{{ old('wrnt', $thing->wrnt) }}">
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
