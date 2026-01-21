<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать вещь</title>
</head>
<body>

<h1>Создать вещь</h1>

<form method="POST" action="/things">
    @csrf

    <div>
        <label>Название</label><br>
        <input type="text" name="name">
    </div>

    <div>
        <label>Описание</label><br>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>Гарантия / срок годности</label><br>
        <input type="date" name="wrnt">
    </div>

    <button type="submit">Сохранить</button>
</form>

</body>
</html>
