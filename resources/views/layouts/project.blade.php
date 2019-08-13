<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="developer" content="flagstudio.ru">
    <meta name="cmsmagazine" content="3a145314dbb5ea88527bc9277a5f8274">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>Title</title>

    <link href="{!! mix('/css/app.css') !!}" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main-wrapper">
    <div class="layout">
        <header id="header" class="header">

        </header>

        @yield('content')

    </div>

    <footer id="footer" class="footer">
        <personal-warning>
            Мы используем данные файлы cookie, данные об IP-адресе и местоположении, разработанные третьими лицами для анализа событий на нашем сайте. Продолжая просмотр страниц сайта, вы принимаете условия его использования. Более подробные сведения можно посмотреть в
            <a class="personal-warning__link" href="#!" target="_blank" title="Политика конфиденциальности">Политике конфиденциальности</a>.
        </personal-warning>
    </footer>
</div>

@include('sprite')

<script src="{!! mix('/js/app.js') !!}"></script>

</body>
</html>
