<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{title}</title>
    <meta charset="utf-8">
    <meta name="description" content="{description}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/public/css/style.min.css">
    <link rel="icon" type="image/x-icon" href="/public/img/favicon.ico">
    <link rel="alternate" type="application/rss xml" title="RSS" href="http://{http-host}/rss"/>

    <!--[if lt IE 9]>
    <script src="/public/js/html5shiv.min.js"></script>
    <script src="/public/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div id="header">
    <div class="overlay">
        <div class="header-top">
            <div class="text-center">
                <div class="sosmed-header-top share-site">
                    <i class="fa fa-facebook" data-toggle="tooltip" data-placement="bottom" title="Facebook"></i>
                    <i class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="bottom" title="Одноклассники"></i>
                    <i class="fa fa-vk" data-toggle="tooltip" data-placement="bottom" title="ВКонтакте"></i>
                    <i class="fa fa-google-plus" data-toggle="tooltip" data-placement="bottom" title="Google Plus"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        {header}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><strong>{http-host}</strong></a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Главная</a></li>
                <li><a href="/add">Прислать</a></li>
                <li><a href="/feedback">Связаться</a></li>
                {gallery-link}
                {pages-links}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/best">По рейтингу</a></li>
                        <li><a href="/new">По дате</a></li>
                        <li><a href="/random">Случайные</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right" role="search" action="/search/" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" required="" placeholder="Поиск" name="search" id="search">
				      	<span class="input-group-btn">
				        	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				      	</span>
                </div>
            </form>
        </div>
    </div>
</nav>
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                {content}
            </div>
            <div class="col-lg-4 col-md-4">
                {sidebar}
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="widget-footer">
                    <h4 class="title-widget-footer">{site-title}</h4>
                    <p class="content-footer">{site-description}</p>
                    <div class="sosmed-footer share-site">
                        <i class="fa fa-facebook" data-toggle="tooltip" data-placement="bottom" title="Facebook"></i>
                        <i class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="bottom" title="Одноклассники"></i>
                        <i class="fa fa-vk" data-toggle="tooltip" data-placement="bottom" title="ВКонтакте"></i>
                        <i class="fa fa-google-plus" data-toggle="tooltip" data-placement="bottom" title="Google Plus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
        </div>
    </div>
</footer>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <p>Copyright © 2015 {http-host}</p>
            </div>
            <div class="col-lg-4">
                <p class="pull-right">
                    <a href="/">Главная</a>
                    <a href="/add">Прислать</a>
                    <a href="/feedback">Связаться</a>
                    <a href="/rss"><i class="fa fa-rss"></i></a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="/public/js/library.min.js"></script>
<script src="/public/js/application.min.js"></script>
<script>
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>
<!-- RT: {runtime} -->