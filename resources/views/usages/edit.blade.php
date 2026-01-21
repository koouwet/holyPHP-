@extends('layouts.app')

@section('title', 'Редактировать выдачу')

@section('content')
    <h1>Редактировать выдачу</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('usages.update', $usage) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Вещь</label><br>
            <select name="thing_id" required>
                @foreach($things as $thing)
                    <option value="{{ $thing->id }}" @selected(old('thing_id', $usage->thing_id)==$thing->id)>
                        {{ $thing->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Кому (пользователь)</label><br>
            <select name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $usage->user_id)==$user->id)>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Где хранится</label><br>
            <select name="place_id" required>
                @foreach($places as $place)
                    <option value="{{ $place->id }}" @selected(old('place_id', $usage->place_id)==$place->id)>
                        {{ $place->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Количество</label><br>
            <input type="number" name="amount" min="1" value="{{ old('amount', $usage->amount) }}" required>
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
