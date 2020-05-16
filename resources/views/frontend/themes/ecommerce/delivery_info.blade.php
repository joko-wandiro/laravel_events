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
                    <li class="com-4"><a href="#">payment</a></li>
                </ul>
                <div id="delivery-info-detail">
                    <div class="row">
                        <div class="col-12">
                            <h1>Customer Details</h1>
                            <?php #echo $customer_form; ?>
                            <?php
                            $errors = request()->session()->get('errors');
                            if ($errors) {
                                $errorMessages = $errors->getMessages();
                            }
                            ?>
                            <?php
                            $url = action(config('app.frontend_namespace') . 'DeliveryInfoController@save');
                            echo Form::open(['method' => 'POST', 'url' => $url, 'id' => "form-delivery-info"]);
                            $name = "";
                            if (isset($delivery_info['name'])) {
                                $name = $delivery_info['name'];
                            }
                            ?>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo $name; ?>" />
                            </div>
                            <?php
                            $labelError = '<label class="error">%1$s</label>';
                            // Display errors
                            if (isset($errorMessages['name'])) {
                                foreach ($errorMessages['name'] as $errorMessage) {
                                    echo sprintf($labelError, e($errorMessage));
                                }
                            }
                            ?>
                            <?php
                            $phone = "";
                            if (isset($delivery_info['phone'])) {
                                $phone = $delivery_info['phone'];
                            }
                            ?>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?php echo $phone; ?>" />
                            </div>
                            <?php
                            $labelError = '<label class="error">%1$s</label>';
                            // Display errors
                            if (isset($errorMessages['phone'])) {
                                foreach ($errorMessages['phone'] as $errorMessage) {
                                    echo sprintf($labelError, e($errorMessage));
                                }
                            }
                            ?>
                            <?php
                            $address = "";
                            if (isset($delivery_info['address'])) {
                                $address = $delivery_info['address'];
                            }
                            ?>
                            <div class="form-group">
                                <textarea name="address" cols="2" class="form-control" placeholder="Address"><?php echo $address; ?></textarea>
                            </div>
                            <?php
                            $labelError = '<label class="error">%1$s</label>';
                            // Display errors
                            if (isset($errorMessages['address'])) {
                                foreach ($errorMessages['address'] as $errorMessage) {
                                    echo sprintf($labelError, e($errorMessage));
                                }
                            }
                            ?>                            
                            <input type="submit" name="submit" value="continue" class="btn">
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
@endsection