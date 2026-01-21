@extends('layouts.app')

@section('title', 'Выдачи вещей')

@section('content')
    <h1>Выдачи вещей</h1>

    <p><a href="{{ route('usages.create') }}">Выдать вещь</a></p>

    <table>
        <thead>
        <tr>
            <th>Вещь</th>
            <th>Пользователь</th>
            <th>Место</th>
            <th>Количество</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($usages as $usage)
            <tr>
                <td>{{ $usage->thing->name }}</td>
                <td>{{ $usage->user->name }}</td>
                <td>{{ $usage->place->name }}</td>
                <td>{{ $usage->amount }}</td>
                <td>
                    <a href="{{ route('usages.edit', $usage) }}">Редактировать</a>
                    <form action="{{ route('usages.destroy', $usage) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить запись?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Пока нет записей о выдаче</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
