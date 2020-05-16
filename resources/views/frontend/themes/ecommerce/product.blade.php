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
                        if ($record['id'] == $product['id_category']) {
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
                <div id="product-detail">
                    <div class="row">
                        <div class="col-8">
                            <div id="left-section">
                                <h1 class="product-title"><?php echo $product['name']; ?></h1>
                                <div class="product-img">
                                    <img src="<?php echo productImageUrl($product['image']); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div id="right-section">
                                <div class="product-price"><?php echo getThousandFormat($product['price']); ?></div>
                                <?php
                                $url = action(config('app.frontend_namespace') . 'ProductController@add');
                                echo Form::open(['method' => 'POST', 'url' => $url, 'id' => "form-product"]);
                                ?>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $product['id']; ?>">
                                    <input type="number" class="form-control" name="qty" id="qty" value="1" min="1">
                                </div>
                                <button type="submit" id="btn-submit" class="btn">add to cart</button>
                                <?php
                                echo Form::close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection