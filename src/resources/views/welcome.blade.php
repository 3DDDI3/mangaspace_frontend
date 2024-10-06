<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @csrf
    @vite(['resources/sass/app.sass', 'resources/js/jquery-3.7.1.js', 'resources/js/app.js'])

    <input type="button" name="login" value="Войти">
    <input type="button" name="check" value="Проверить">
    <input type="button" name="logout" value="Выйти">
    <input type="button" name="parse" value="Парсить">

    <input type="text" name="name" placeholder="название тайтла">

</head>

</html>
