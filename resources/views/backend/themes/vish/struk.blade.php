<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="Joko Wandiro">
        <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
        <link rel="icon" href="<?php echo url('images/logo.png'); ?>">
        <title><?php echo trans('main.app'); ?></title>
        <!-- CSS files -->
        <link href="<?php echo url('css/themes/vish/struk.css'); ?>" rel="stylesheet">
        <link href="<?php echo url('css/themes/vish/struk.css'); ?>" media="print" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            site = <?php echo json_encode($jsParameters); ?>
        </script>
    </head>
    <body>
        <div id="company">
            <div class="logo"><img src="<?php echo image_url(settings('logo')); ?>" height="40" /></div>
            <div class="address"><?php echo nl2br(settings('address')); ?></div>
            <div class="phone"><?php echo settings('phone'); ?></div>
        </div>
        <div id="order-info">
            <div class="order-no"><?php echo trans('main.sales_no'); ?>: <?php echo $order['id']; ?></div>
            <div class="date"><?php echo trans('main.date'); ?>: <?php echo date("d F Y", strtotime($order['date'])); ?></div>
        </div>
        <table id="order-table" class="table order-table">
            <thead>
                <tr>
                    <th scope="col" width="60%"><?php echo trans('dkscaffolding.column.name'); ?></th>
                    <th scope="col" width="20%"><?php echo trans('dkscaffolding.column.qty'); ?></th>
                    <th scope="col" width="20%"><?php echo trans('dkscaffolding.column.price'); ?></th>
                    <th scope="col" width="20%"><?php echo trans('dkscaffolding.column.subtotal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                foreach ($order_products as $product) {
                    $id_product = $product['id_product'];
                    $price = $products[$id_product]['price'];
                    $subtotal = $price * $product['qty'];
                    ?>
                    <tr class="row-product">
                        <td class="description" width="60%"><span class="name"><?php echo $products[$id_product]['name']; ?></span></td>
                        <td class="qty" width="20%"><?php echo $product['qty']; ?></td>
                        <td class="price" width="20%"><?php echo getThousandFormat($products[$id_product]['price']); ?></td>
                        <td class="price" width="20%"><?php echo getThousandFormat($subtotal); ?></td>
                    </tr>
                    <?php
                    $index++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="subtotal">
                    <td class="" colspan="3"><?php echo trans('main.subtotal'); ?></td>
                    <td class="price"><?php echo getThousandFormat($order['subtotal']); ?></td>
                </tr>
                <tr class="ppn">
                    <td class="" colspan="3"><?php echo trans('main.delivery.fee'); ?></td>
                    <td class="price"><?php echo getThousandFormat(10000); ?></td>
                </tr>
                <tr class="ppn">
                    <td class="" colspan="3"><?php echo trans('main.tax'); ?></td>
                    <td class="price"><?php echo getThousandFormat($order['ppn']); ?></td>
                </tr>
                <tr class="total">
                    <td class="" colspan="3"><?php echo trans('main.total'); ?></td>
                    <td class="price"><?php echo getThousandFormat($order['total']); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php
        if (request('action') != "view") {
            ?>
            <script>
                window.print();
            </script>
            <?php
        }
        ?>
    </body>
</html>