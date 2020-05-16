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
    <body id="<?php echo $id_page; ?>">
        <div id="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <?php
                    $url_homepage = action(config('app.frontend_namespace') . 'HomePageController@index');
                    ?>
                    <a class="navbar-brand" href="<?php echo $url_homepage; ?>">Store</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav navbar-right">
                            <li class="nav-item active">
                                <a class="nav-link nav-cart" href="#"><i class="fas fa-shopping-cart"></i></a>
                                <div class="cart-info">
                                    <div class="triangle">&nbsp;</div>
                                    <table class="table products-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">menu item</th>
                                                <th scope="col">quantity</th>
                                                <th scope="col">subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cart = session('cart');
                                            if ($cart) {
                                                // Get product ids
                                                $ids_product = array();
                                                foreach ($cart as $id_product => $product) {
                                                    $ids_product[] = $id_product;
                                                }
                                                // Get product
                                                $columns = array(
                                                    'products.*',
                                                    'categories.name AS category_name'
                                                );
                                                $Model = new \App\Models\Products;
                                                $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
                                                        ->whereIn('products.id', $ids_product);
                                                $products = $Model->select($columns)->get();
                                                foreach ($products as $product) {
                                                    $id_product = $product['id'];
                                                    $qty = $cart[$id_product]['qty'];
                                                    $subtotal = $product['price'] * $qty;
                                                    ?>
                                                    <tr>
                                                        <td class="description"><img src="<?php echo productImageUrl($product['image']); ?>" width="100" /><?php echo $product['name']; ?></td>
                                                        <td class="qty">x <?php echo $qty; ?></td>
                                                        <td class="subtotal"><?php echo getThousandFormat($subtotal); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    $url = action(config('app.frontend_namespace') . 'CartController@index');
                                    ?>
                                    <div><a href="<?php echo $url; ?>" class="btn btn-go">GO TO CART</a></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="category.html">Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        @yield('slider')

        @yield('content')

        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div id="footer-store-name">store delivery</div>
                        <div id="footer-store-phone"><i class="fas fa-phone"></i>10000 10</div>
                        <div class="social-media">
                            <ul class="social-media-icons">
                                <li><a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#" class="instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
                            </ul>
                        </div>
                        <ul class="footer-menu-links">
                            <li><a href="#">Kebijakan Privasi</a></li>
                            <li><a href="#">Syarat dan Ketentuan</a></li>
                            <li>&copy; 2019 Store Corporation. Used Under License. All rights reserved.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
