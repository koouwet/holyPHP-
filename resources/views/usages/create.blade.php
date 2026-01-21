@extends('layouts.app')

@section('title', 'Выдать вещь')

@section('content')
    <h1>Выдать вещь</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usages.store') }}">
        @csrf

        <div>
            <label>Вещь</label><br>
            <select name="thing_id" required>
                <option value="">Выберите вещь</option>
                @foreach($things as $thing)
                    <option value="{{ $thing->id }}" @selected(old('thing_id')==$thing->id)>
                        {{ $thing->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Кому (пользователь)</label><br>
            <select name="user_id" required>
                <option value="">Выберите пользователя</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id')==$user->id)>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Где хранится</label><br>
            <select name="place_id" required>
                <option value="">Выберите место</option>
                @foreach($places as $place)
                    <option value="{{ $place->id }}" @selected(old('place_id')==$place->id)>
                        {{ $place->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Количество</label><br>
            <input type="number" name="amount" min="1" value="{{ old('amount', 1) }}" required>
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
