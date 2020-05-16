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
                    <li class="com-4 active"><a href="<?php echo $url_delivery_info; ?>">delivery info</a></li>
                    <li class="com-4 active"><a href="<?php echo $url_payment; ?>">payment</a></li>
                </ul>
                <div id="payment-detail">
                    <div class="xrow">
                        <div class="com-6">
                            <div id="section-right">
                                <table class="table order-table">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="3">order summary</th>
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
                                                <td class="description"><?php echo $product['name']; ?></td>
                                                <td class="qty">x<?php echo $qty; ?></td>
                                                <td class="price"><?php echo getThousandFormat($subtotal); ?></td>
                                            </tr>                                            
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $delivery_fee = 10000;
                                    $total_delivery = $total + $delivery_fee;
                                    $ppn = $total_delivery * 10 / 100;
                                    $grand_total = $total_delivery + $ppn;
                                    ?>
                                    <tfoot>
                                        <tr class="subtotal">
                                            <td class="" colspan="2">Subtotal</td>
                                            <td class="price"><?php echo getThousandFormat($total); ?></td>
                                        </tr>
                                        <tr class="delivery-fee">
                                            <td class="" colspan="2">Delivery fee</td>
                                            <td class="price"><?php echo getThousandFormat($delivery_fee); ?></td>
                                        </tr>
                                        <tr class="ppn">
                                            <td class="" colspan="2">PPN 10%</td>
                                            <td class="price"><?php echo getThousandFormat($ppn); ?></td>
                                        </tr>
                                        <tr class="total">
                                            <td class="" colspan="2">TOTAL</td>
                                            <td class="price"><?php echo getThousandFormat($grand_total); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="com-6">
                            <div id="section-left">
                                <div class="order-info">
                                    <p class="label">DELIVER TO</p>
                                    <p class="value"><?php echo $delivery_info['address']; ?></p>
                                </div>
                                <div class="order-info">
                                    <p class="label">PAY WITH</p>
                                    <div class="value"><span class="payment-method">Cash On Delivery</span></div>
                                </div>
                                <?php
                                $url = action(config('app.frontend_namespace') . 'PaymentController@save');
                                echo Form::open(['method' => 'POST', 'url' => $url, 'id' => "payment-form"]);
                                ?>
                                <input type="submit" name="submit" value="place my order" class="btn">
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