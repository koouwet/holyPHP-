@extends('layouts.app')

@section('title', 'Архив вещей')

@section('content')
<h1>Архив вещей</h1>

<table>
    <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Хозяин</th>
            <th>Последний пользователь</th>
            <th>Место</th>
            <th>Статус</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($archives as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description ?? '—' }}</td>
            <td>{{ $item->owner_name }}</td>
            <td>{{ $item->last_user_name ?? '—' }}</td>
            <td>{{ $item->place_name ?? '—' }}</td>
            <td>
                {{ $item->restored ? 'Восстановлена' : 'В архиве' }}
            </td>
            <td>
                @if (! $item->restored)
                    <form method="POST" action="{{ route('things.archive.restore', $item->id) }}">
                        @csrf
                        <button type="submit">Восстановить</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
