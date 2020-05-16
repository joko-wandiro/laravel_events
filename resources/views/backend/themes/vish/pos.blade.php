@extends('backend.themes.vish.default')

@section('content')
<?php
$url = ( isset($action) && $action == "edit" ) ? action(config('app.backend_namespace') . 'PosController@update', array('id' => $order['id'])) : action(config('app.backend_namespace') . 'PosController@store');
$method = ( isset($action) && $action == "edit" ) ? 'PUT' : 'POST';
$attributes = array('class' => 'form-control');
$attributes_qty = array('class' => 'form-control', 'type' => 'number', 'value' => 1, 'min' => 1);
echo Form::open(['method' => $method, 'url' => $url]);
?>
<div class="container">
    <div id="pos-content">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div id="order-table-wrapper">
                    <table id="order-table" class="table order-table">
                        <thead>
                            <tr>
                                <th scope="col" width="60%"><?php echo trans('dkscaffolding.column.name'); ?></th>
                                <th scope="col" width="20%"><?php echo trans('dkscaffolding.column.quantity'); ?></th>
                                <th scope="col" width="20%"><?php echo trans('dkscaffolding.column.price'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($action) && $action == "edit") {
                                $index = 0;
                                foreach ($order_products as $product) {
                                    $id_product = $product['id_product'];
                                    ?>
                                    <tr class="row-product">
                                        <td class="description" width="60%"><a class="btn-delete"><i class="fa fa-trash"></i></a><span class="name"><?php echo $products[$id_product]['name']; ?></span></td>
                                        <td class="qty" width="20%">
                                            <?php
                                            echo Form::hidden('products[' . $index . '][id]', $product['id_order'], $attributes);
                                            echo Form::hidden('products[' . $index . '][id_product]', $id_product, $attributes);
                                            echo Form::number('products[' . $index . '][qty]', $product['qty'], $attributes_qty);
                                            ?>
                                        </td>
                                        <td class="price" width="20%"><?php echo getThousandFormat($products[$id_product]['price']); ?></td>
                                    </tr>
                                    <?php
                                    $index++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="subtotal">
                                <td class="" colspan="3"><?php echo trans('main.subtotal'); ?></td>
                                <td class="price">0</td>
                            </tr>
                            <tr class="ppn">
                                <td class="" colspan="3"><?php echo trans('main.tax'); ?></td>
                                <td class="price">0</td>
                            </tr>
                            <tr class="total">
                                <td class="" colspan="3"><?php echo trans('main.total'); ?></td>
                                <td class="price">0</td>
                            </tr>
                            <tr class="paid">
                                <td class="" colspan="3"><?php echo trans('main.cash'); ?></td>
                                <?php
                                if (isset($action) && $action == "edit") {
                                    ?>
                                    <td class="price"><?php echo Form::text('nominal', getThousandFormat($order['paid']), $attributes); ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td class="price"><?php echo Form::text('nominal', null, $attributes); ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr class="change">
                                <td class="" colspan="3"><?php echo trans('main.change'); ?></td>
                                <td class="price">-</td>
                            </tr>
                            <tr>
                                <td colspan="4"><input type="button" name="cancel" class="btn btn-white btn-block" value="<?php echo trans('main.btn.cancel'); ?>" /></td>
                            </tr>
                            <tr>
                                <td colspan="4"><input type="submit" name="submit" class="btn btn-blue btn-block" value="<?php echo trans('main.btn.pay'); ?>" /></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-sm-6 col-md-8">
                <ul id="menus-navigation">
                    <?php
                    foreach ($categories as $category) {
                        $id_category = str_replace(" ", "-", strtolower($category['name']));
                        ?>
                        <li><a href="#" data-id="<?php echo $id_category; ?>"><?php echo $category['name']; ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <ul id="menus-list" class="xrow">
                    <?php
                    foreach ($products as $product) {
                        $id_category = str_replace(" ", "-", strtolower($product['category_name']));
                        ?>
                        <li class="com-4 <?php echo $id_category; ?>">
                            <div class="menu">
                                <a href="#" class="product" data-id="<?php echo $product['id']; ?>">
                                    <div class="menu-img"><img class="img-responsive" src="<?php echo productImageUrl($product['image']); ?>" /></div>
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
<?php
echo Form::close();
?>
<table id="template-product" class="hide">
    <tbody>
        <tr class="row-empty">
            <td colspan="4"><?php echo trans('main.products.empty'); ?></td>
        </tr>
        <?php
        $attributes = array('class' => 'form-control');
        $attributes_qty = array('class' => 'form-control', 'type' => 'number', 'value' => 1, 'min' => 1);
        ?>
        <tr class="row-product">
            <td class="description" width="60%"><a class="btn-delete"><i class="fa fa-trash"></i></a><span class="name">king deals cheeseburger</span></td>
            <td class="qty" width="20%">
                <?php
                echo Form::hidden('products[][id]', null, $attributes);
                echo Form::hidden('products[][id_product]', null, $attributes);
                echo Form::number('products[][qty]', null, $attributes_qty);
                ?>
            </td>
            <td class="price" width="20%">Rp. 25.000</td>
        </tr>        
    </tbody>
</table>
@endsection