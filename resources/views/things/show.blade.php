@extends('layouts.app')

@section('title', $thing->name)

@section('content')
    <h1>{{ $thing->name }}</h1>

    <p><strong>Описание:</strong> {{ $thing->description ?? '—' }}</p>
    <p><strong>Гарантия / срок годности:</strong> {{ $thing->wrnt ?? '—' }}</p>

    <h2>Использование</h2>

    @if ($thing->usage)
        <table>
            <thead>
            <tr>
                <th>Кому</th>
                <th>Где хранится</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $thing->usage->user->name }}</td>
                <td>{{ $thing->usage->place->name }}</td>
                <td>{{ $thing->usage->amount }}</td>
            </tr>
            </tbody>
        </table>
    @else
        <p>Эта вещь сейчас ни у кого не используется</p>
    @endif
@endsection
