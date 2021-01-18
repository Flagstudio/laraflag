<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="developer" content="flagstudio.ru">
    <meta name="cmsmagazine" content="3a145314dbb5ea88527bc9277a5f8274">
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    @isset($meta)
        <meta name="title" content="{{ $meta->title ?? '' }}">
        <meta name="description" content="{{ $meta->description ?? '' }}">
        <meta name="keywords" content="{{ $meta->keywords ?? '' }}">
    @endif

    <title>{{ isset($meta) ? $meta->tag_title : ''  }}</title>

    <link href="{!! mix('/css/components.css') !!}" rel="stylesheet" type="text/css">
    <link href="{!! mix('/css/app.css') !!}" rel="stylesheet" type="text/css">

    {!! $headScripts ?? '' !!}
</head>
<body>

{!! $beginScripts ?? '' !!}

@if (optional(auth()->user())->isAdmin())
    {!! AdminBar::generate() !!}
@endif

<div class="main-wrapper">
    <div class="layout">
        <header id="header" class="header">

        </header>

        @yield('content')

    </div>

    <footer id="footer" class="footer">
        <personal-warning>
            <template v-slot:default>
                Мы используем данные файлы cookie, данные об IP-адресе и местоположении, разработанные третьими лицами для анализа событий на нашем сайте. Продолжая просмотр страниц сайта, вы принимаете условия его использования. Более подробные сведения можно посмотреть в
                <a class="personal-warning__link" href="#!" target="_blank" title="Политика конфиденциальности">Политике конфиденциальности</a>.
            </template>
        </personal-warning>
    </footer>
</div>

<div id="update-warning" class="update-warning" style="display: none">
    <p data-nosnippet>Вы пользуетесь устаревшей версией браузера. Данная версия браузера не поддерживает многие современные технологии, из-за чего страницы отображаются некорректно, а главное — на сайте могут работать не все функции.<br> Рекомендуем установить <a href="https://www.google.com/chrome/" target="_blank" rel="nofollow noopener">Google Chrome</a> — современный, быстрый и безопасный браузер.</p>
    <button class="update-warning__close js--close-update-warning" type="button">Закрыть</button>
</div>

@include('sprite')

<script src="{!! mix('/js/check-support.js') !!}"></script>
<script src="{!! mix('/js/manifest.js') !!}"></script>
<script src="{!! mix('/js/vendor.js') !!}"></script>
<script src="{!! mix('/js/app.js') !!}"></script>

@if(! app()->environment('local') && config('app.jira_collector_id') && optional(auth()->user())->isAdmin())
    <script type="text/javascript" src="https://jira.flagstudio.ru/s/95ad89360eec1845f13b7a13ded5c0c4-T/-y6xh9q/73015/19eec8c46095745849ebdd927f182f88/2.0.23/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=ru-RU&collectorId={{ config('app.jira_collector_id') }}"></script>
@endif

{!! $endScripts ?? '' !!}

</body>
</html>
