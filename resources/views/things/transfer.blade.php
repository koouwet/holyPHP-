@extends('layouts.app')

@section('title', 'Передать вещь')

@section('content')
    <h1>Передать вещь: {{ $thing->name }}</h1>

    <form method="POST" action="{{ route('things.transfer', $thing) }}">
        @csrf

        <div>
            <label for="user_id">Кому передать:</label><br>
            <select name="user_id" id="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="place_id">Место хранения:</label><br>
            <select name="place_id" id="place_id" required>
                @foreach ($places as $place)
                    <option value="{{ $place->id }}">
                        {{ $place->name }}
                        @if($place->repair) — ремонт @endif
                        @if($place->work) — в работе @endif
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <button type="submit">Передать</button>
        <a href="{{ route('things.show', $thing) }}">Отмена</a>
    </form>
@endsection
