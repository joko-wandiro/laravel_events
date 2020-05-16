<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.6">
        <title>Homepage</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/blog/">
        <!-- Bootstrap core CSS -->
        <link href="<?php echo url('css/frontend/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Favicons -->
        <link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
        <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
        <link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
        <link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
        <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
        <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
        <meta name="theme-color" content="#563d7c">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
        <link href="<?php echo url('css/frontend/owl.carousel.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo url('css/frontend/owl.theme.default.min.css'); ?>" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo url('css/frontend/all.css'); ?>" rel="stylesheet">
        <link href="<?php echo url('css/frontend/blog.css'); ?>" rel="stylesheet">
        <link href="<?php echo url('css/frontend/main.css'); ?>" rel="stylesheet">
        <script src="<?php echo url('js/frontend/jquery.min.js'); ?>"></script>
        <script src="<?php echo url('js/frontend/owl.carousel.min.js'); ?>"></script>
        <script src="<?php echo url('js/frontend/homepage.js'); ?>"></script>
    </head>
    <body id="<?php echo $page; ?>">
        <div id="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <?php
                    $url_homepage = action(config('app.frontend_namespace') . 'HomePageController@index');
                    ?>
                    <a class="navbar-brand" href="<?php echo $url_homepage; ?>">Events</a>
                </nav>
            </div>
        </div>

        @yield('content')

        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="footer-menu-links">
                            <li>&copy; 2020 Joko Wandiro. All rights reserved.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
