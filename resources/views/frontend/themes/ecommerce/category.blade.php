@extends('frontend.themes.ecommerce.default')

@section('content')
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <form id="form-search" action="category.html" method="POST">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <div class="input-group mb-2 input-search">
                                <input type="text" class="form-control" name="search" id="search" placeholder="Search menu...">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="category-links">
                    <?php
                    foreach ($categories as $record) {
                        $class = '';
                        if ($record['id'] == $category['id']) {
                            $class = ' class="active"';
                        }
                        ?>
                        <li><a href="<?php echo url('category/' . to_url_component($record['name'])); ?>"<?php echo $class; ?>><?php echo $record['name']; ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-9">
                <ul id="menus-list" class="xrow">
                    <?php
                    foreach ($products as $product) {
                        ?>
                        <li class="com-6">
                            <div class="menu">
                                <a href="<?php echo url('product/' . to_url_component($product['name'])); ?>">
                                    <div class="menu-img"><img class="img-fluid" src="<?php echo productImageUrl($product['image']); ?>" /></div>
                                    <div class="menu-content"><?php echo $product['name']; ?></div>
                                    <div class="menu-price"><?php echo getThousandFormat($product['price']); ?></div>
                                </a>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection