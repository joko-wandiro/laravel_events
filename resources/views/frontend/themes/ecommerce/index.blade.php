@extends('frontend.themes.ecommerce.default')

@section('slider')
<div id="slider">
    <div class="owl-carousel owl-theme">
        <div class="item"><a href="#"><img class="img-fluid" src="images/slider/slide_01.jpg" /></a></div>
        <div class="item"><a href="#"><img class="img-fluid" src="images/slider/slide_02.jpg" /></a></div>
        <div class="item"><a href="#"><img class="img-fluid" src="images/slider/slide_03.jpg" /></a></div>
        <div class="item"><a href="#"><img class="img-fluid" src="images/slider/slide_04.jpg" /></a></div>
    </div>
</div>
@endsection

@section('content')
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 id="menus-title">our menus</h1>
                <ul id="menus-list" class="xrow">
                    <?php
                    foreach ($categories as $category) {
                        ?>
                        <li class="com-4">
                            <div class="menu">
                                <a href="<?php echo url('category/' . to_url_component($category['name'])); ?>">
                                    <div class="menu-img"><img class="img-fluid" src="<?php echo categoryImageUrl($category['image']); ?>" /></div>
                                    <div class="menu-content"><?php echo $category['name']; ?></div>
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
