@extends('layouts.app')

@section('title', 'Мои вещи')

@section('content')
    <h1>Мои вещи</h1>

    <p><a href="{{ route('things.create') }}">Создать вещь</a></p>

    <table>
        <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Гарантия / срок</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($things as $thing)
            <tr>
                <td>{{ $thing->name }}</td>
                <td>{{ $thing->description }}</td>
                <td>{{ $thing->wrnt }}</td>
                <td>
                    <a href="{{ route('things.show', $thing) }}">Открыть</a> |
                    <a href="{{ route('things.edit', $thing) }}">Редактировать</a>
                    <form action="{{ route('things.destroy', $thing) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить вещь?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Пока нет вещей</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
