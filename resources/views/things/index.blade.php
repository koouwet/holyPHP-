@extends('layouts.app')

@section('title', $title ?? 'Вещи')

@section('content')
    <h1>{{ $title ?? 'Вещи' }}</h1>

    <p><a href="{{ route('things.create') }}">Создать вещь</a></p>

    <table>
        <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Гарантия / срок</th>
            <th>Хозяин</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($things as $thing)
            <tr>
                <td>{{ $thing->name }}</td>
                <td>{{ $thing->description }}</td>
                <td>{{ $thing->wrnt }}</td>
                <td>{{ $thing->master?->name ?? '—' }}</td>
                <td>
                    <a href="{{ route('things.show', $thing) }}">Открыть</a>

                    @can('update', $thing)
        |               <a href="{{ route('things.edit', $thing) }}">Редактировать</a>
                    @endcan

                    @can('transfer', $thing)
        |               <a href="{{ route('things.transfer.form', $thing) }}">Передать</a>
                    @endcan

                    @can('delete', $thing)
                        <form action="{{ route('things.destroy', $thing) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить вещь?')">
                            Удалить
                        </button>
                        </form>
                    @endcan
                </td>

            </tr>
        @empty
            <tr><td colspan="5">Пока нет вещей</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
