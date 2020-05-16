@extends('frontend.themes.ecommerce.default')

@section('content')
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $url_cart = action(config('app.frontend_namespace') . 'CartController@index');
                $url_delivery_info = action(config('app.frontend_namespace') . 'DeliveryInfoController@index');
                $url_payment = action(config('app.frontend_namespace') . 'PaymentController@index');
                ?>
                <ul id="order-steps" class="xrow">
                    <li class="com-4 active"><a href="<?php echo $url_cart; ?>">cart</a></li>
                    <li class="com-4"><a href="#">delivery info</a></li>
                    <li class="com-4"><a href="#">payment</a></li>
                </ul>
                <?php
                $url = action(config('app.frontend_namespace') . 'CartController@add');
                echo Form::open(['method' => 'POST', 'url' => $url, 'id' => "form-cart"]);
                ?>
                <div id="cart-detail">
                    <div class="xrow">
                        <div class="com-8">
                            <div id="section-left">
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
                                        $total = 0;
                                        foreach ($products as $product) {
                                            $id_product = $product['id'];
                                            $qty = $cart[$id_product]['qty'];
                                            $subtotal = $product['price'] * $qty;
                                            $total += $subtotal;
                                            ?>
                                            <tr>
                                                <td class="description"><img src="<?php echo productImageUrl($product['image']); ?>" width="100" /><?php echo $product['name']; ?></td>
                                                <td class="qty">
                                                    <input type="hidden" name="product[<?php echo $id_product; ?>][id]" value="<?php echo $id_product; ?>" />
                                                    <input type="number" name="product[<?php echo $id_product; ?>][qty]" value="<?php echo $qty; ?>" /></td>
                                                <td class="subtotal"><?php echo getThousandFormat($subtotal); ?> <a><i class=""></i></a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="note">
                                    <p class="note-info">ADD NOTES</p>
                                    <textarea name="note" rows="2" placeholder="Add notes to your order here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="com-4">
                            <div id="section-right">
                                <div class="order-info">
                                    <p class="title">ORDER TOTAL*</p>
                                    <p class="price"><?php echo getThousandFormat($total); ?></p>
                                    <p class="description">*Price might change due to your delivery location.</p>
                                </div>
                                <input type="submit" name="submit" value="continue" class="btn" />
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                echo Form::close();
                ?>
            </div>
        </div>
    </div>
</div>
@endsection