@extends('layouts.app')

@section('title', $thing->name)

@section('content')
    <h1>{{ $thing->name }}</h1>

    <p><strong>Описание:</strong> {{ $thing->description ?? '—' }}</p>
    <p><strong>Гарантия / срок годности:</strong> {{ $thing->wrnt ?? '—' }}</p>

    <h2>Выдачи / использование</h2>
    <table>
        <thead>
        <tr>
            <th>Кому</th>
            <th>Где хранится</th>
            <th>Количество</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($thing->usages as $usage)
            <tr>
                <td>{{ $usage->user->name }}</td>
                <td>{{ $usage->place->name }}</td>
                <td>{{ $usage->amount }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Эта вещь пока никуда не выдана</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
