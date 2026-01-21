@extends('layouts.app')

@section('title', 'Места хранения')

@section('content')
    <h1>Места хранения</h1>

    <p><a href="{{ route('places.create') }}">Добавить место</a></p>

    <table>
        <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Ремонт/мойка</th>
            <th>В работе</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($places as $place)
            <tr>
                <td>{{ $place->name }}</td>
                <td>{{ $place->description }}</td>
                <td>{{ $place->repair ? 'Да' : 'Нет' }}</td>
                <td>{{ $place->work ? 'Да' : 'Нет' }}</td>
                <td>
                    <a href="{{ route('places.edit', $place) }}">Редактировать</a>
                    <form action="{{ route('places.destroy', $place) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить место?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Пока нет мест</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
