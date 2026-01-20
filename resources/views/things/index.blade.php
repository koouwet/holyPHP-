<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список вещей</title>
</head>
<body>

<h1>Список вещей</h1>

<ul>
    @foreach ($things as $thing)
        <li>
            {{ $thing->name }}
        </li>
    @endforeach
</ul>

</body>
</html>
