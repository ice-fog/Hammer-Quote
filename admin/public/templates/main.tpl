<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{title}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/admin/public/styles/style.min.css"/>
    <link rel="icon" type="image/x-icon" href="/admin/public/images/favicon.ico" >
    <script type="text/javascript" src="/admin/public/scripts/library.min.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/codemirror/codemirror.js"></script>
    <script type="text/javascript" src="/admin/public/scripts/application.min.js"></script>
</head>
<body>
<div id="header-wrap">
    <div id="header" class="container-16">
        <div id="nav">
            <ul>
                <li><a href="/admin/content"><span class="md md-apps"></span>Контент</a></li>
                <li><a href="/admin/category"><span class="md md-folder-open"></span>Категории</a></li>
                <li><a href="/admin/pages"><span class="md md-content-copy"></span>Страницы</a></li>
                <li><a href="/admin/feedback"><span class="md md-contacts"></span>Обратная связь</a></li>
                <li><a href="/admin/delivery"><span class="md md-email"></span>Рассылка</a></li>
                <li><a href="/admin/statistics"><span class="md md-trending-up"></span>Статистика</a></li>
                <li><a href="/admin/editor"><span class="md md-style"></span>Редактор</a></li>
                <li><a href="/admin/settings"><span class="md md-tune"></span>Настройки</a></li>
                <li><a href="/admin/logout"><span class="md md-exit-to-app"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<div id="content-outer">
    <div id="content-wrapper" class="container-16">
        <div class="grid-12">
            {content}
        </div>
        <div class="grid-4">
            {sidebar}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>