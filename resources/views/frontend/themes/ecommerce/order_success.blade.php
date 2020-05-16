@extends('frontend.themes.ecommerce.default')

@section('content')
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="order-message">
                    <h1>THANK YOU</h1>
                    <p>YOUR ORDER HAS BEEN CREATED</p>
                </div>
                <div id="payment-detail">
                    <div class="xrow">
                        <div class="com-6">
                            <div id="section-right">
                                <div class="order-info">
                                    <p class="id">order <?php echo $order->id; ?></p>
                                    <p class="date"><?php echo date("d F Y, H:i", strtotime($order->created_at)); ?></p>
                                </div>
                                <div class="order-info">
                                    <p class="label">DELIVER FROM</p>
                                    <p class="value">Toko Utama</p>
                                </div>
                                <div class="order-info">
                                    <p class="label">DELIVER TO</p>
                                    <p class="value"><?php echo $order->address; ?></p>
                                </div>
                                <div class="order-info">
                                    <p class="label">ORDER STATUS</p>
                                    <div class="value"><span class="payment-method">Success</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="com-6">
                            <div id="section-left">
                                <div class="order-payment-info">
                                    <p class="title">PAYMENT TOTAL</p>
                                    <p class="price"><?php echo getThousandFormat($order->total); ?></p>
<!--                                    <p class="nominal">Cash (Rp. 150.000)</p>-->
                                </div>
                                <table class="table order-table">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="3">order details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($products as $product) {
                                            $subtotal = $product['price'] * $product['qty'];
                                            ?>
                                            <tr>
                                                <td class="description"><?php echo $product['name']; ?></td>
                                                <td class="qty">x<?php echo $product['qty']; ?></td>
                                                <td class="price"><?php echo getThousandFormat($subtotal); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                    $delivery_fee = 10000;
                                    ?>                                    
                                    <tfoot>
                                        <tr class="subtotal">
                                            <td class="" colspan="2">Subtotal</td>
                                            <td class="price"><?php echo getThousandFormat($order->subtotal); ?></td>
                                        </tr>
                                        <tr class="delivery-fee">
                                            <td class="" colspan="2">Delivery fee</td>
                                            <td class="price"><?php echo getThousandFormat($delivery_fee); ?></td>
                                        </tr>
                                        <tr class="ppn">
                                            <td class="" colspan="2">PPN 10%</td>
                                            <td class="price"><?php echo getThousandFormat($order->ppn); ?></td>
                                        </tr>
                                        <tr class="total">
                                            <td class="" colspan="2">TOTAL</td>
                                            <td class="price"><?php echo getThousandFormat($order->total); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!--                                <div class="order-note">NOTES: Testing doang</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection