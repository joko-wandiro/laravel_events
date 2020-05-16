<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scaffolding;
use Form;
use DB;
use Validator;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Orders;
use App\Models\OrderProducts;

class PosController extends BackEndController
{

    protected $table = 'orders';
    protected $masterView = 'backend.themes.vish.pos';

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->js = array();
        $this->css = array();
        // Add css files
        $this->addCSS('font.awesome', 'css/font-awesome.min.css');
        $this->addCSS('jquery.ui', 'css/jquery-ui.css');
        $this->addCSS('bootstrap', 'css/bootstrap.min.css');
        $this->addCSS('dkscaffolding', 'css/vishscaffolding.css');
        $this->addCSS('ie10', 'css/ie10-viewport-bug-workaround.css');
        $this->addCSS('themes', 'css/themes/vish/theme.css');
        $this->addCSS('responsive', 'css/themes/vish/responsive.css');
        $this->addJS('jquery', 'js/jquery.min.js');
        $this->addJS('jquery.ui', 'js/jquery-ui.min.js');
        $this->addJS('jquery.blockUI', 'js/jquery.blockUI.js');
        $this->addJS('bootstrap', 'js/bootstrap.min.js');
        $this->addJS('jquery.validate', 'js/jquery.validate.min.js');
        $this->addJS('ie10', 'js/ie10-viewport-bug-workaround.js');
        $this->addJS('zerobox', 'js/zerobox.js');
        $this->addJS('zerovalidation', 'js/zerovalidation.js');
        $this->addJS('zeromask', 'js/zeromask.js');
        $this->addJS('site', 'js/backend/site.js');
        $this->addJS('ingoods', 'js/backend/order.js');
        $this->addJS('exgoodsdetail', 'js/backend/order_product.js');
//        $Products = new Products;
//        $this->jsParameters['products'] = $Products->gets();
    }

    public function create()
    {
        $categories = Categories::gets();
        $products = Products::gets();
        $this->jsParameters['products'] = $products;
        $parameters = array(
            'id_page' => "pos",
            'categories' => $categories,
            'products' => $products,
        );
        return $this->render($parameters);
    }

    public function store()
    {
        $Request = request();
        $request = $Request->all();
        $request['nominal'] = to_number($request['nominal']);
        // Validation
        $validation_rules = array(
            'nominal' => 'required|numeric',
            'products.*.qty' => 'required|numeric'
        );
        $validation_messages = array();
        $validation_messages['products.*.qty.numeric'] = str_replace(":attribute", "quantity", trans('validation.numeric'));
        $validation_messages['products.*.qty.required'] = str_replace(":attribute", "quantity", trans('validation.required'));
        $validator = Validator::make($request, $validation_rules, $validation_messages);
        if ($validator->fails()) {
            // Set parameters for HTTP Response
            $parameters = array(
                'status' => 400,
                'type' => "error",
                'errors' => $validator->errors()->messages()
            );
            // Send Response
            $Response = new JsonResponse($parameters, 400);
            $Response->send();
            exit;
        }
        $result = DB::transaction(function ($db) use ($request) {
                    $ProductsModel = new Products;
                    $products = $ProductsModel->gets();
                    $subtotal = 0;
                    foreach ($request['products'] as $record) {
                        $id_product = $record['id_product'];
                        $product = $products[$id_product];
                        $price = $product['price'] * $record['qty'];
                        $subtotal += $price;
                    }
                    $tax = $subtotal * settings('tax') / 100;
                    $total = $subtotal + $tax;
                    $change = $request['nominal'] - $total;
                    $parameters = array(
                        'id_user' => session('id'),
                        'subtotal' => $subtotal,
                        'ppn' => $tax,
                        'total' => $total,
                        'paid' => $request['nominal'],
                        'change' => $change,
                    );
                    // Insert order
                    $OrdersModel = new Orders;
                    $order = $OrdersModel->create($parameters);
                    // Insert order products
                    foreach ($request['products'] as $record) {
                        $parameters = array(
                            'id_order' => $order->id,
                            'id_product' => $record['id_product'],
                            'qty' => $record['qty'],
                        );
                        $OrderProductsModel = new OrderProducts;
                        $order_product = $OrderProductsModel->create($parameters);
                    }
                    return $order;
                });
        // Set parameters for HTTP Response
        $parameters = array(
            'status' => 200,
            'type' => "success",
            'message' => "Transaksi berhasil dilakukan silakan print struk.",
            'url' => action(config('app.backend_namespace') . 'PosController@show', array('id_order' => $result['id'])),
        );
        // Send Response
        $Response = new JsonResponse($parameters, 200);
        $Response->send();
        exit;
    }

    public function edit($id)
    {
        $categories = Categories::gets();
        $products = Products::gets();
        $order = Orders::gets($id);
        // Is valid record
        if (!$order) {
            // Redirect to List Page
            // Set session flash for notify Entry is not exist
            return redirect(action(config('app.backend_namespace') . 'OrdersController@index'))
                            ->with('dk_orders_info_error', trans('dkscaffolding.no.entry'));
        }
        $order_products = Orders::get_products($id);
        $this->jsParameters['products'] = $products;
        $this->jsParameters['method'] = "edit";
        $parameters = array(
            'action' => "edit",
            'id_page' => "pos",
            'categories' => $categories,
            'products' => $products,
            'order' => $order,
            'order_products' => $order_products,
        );
        return $this->render($parameters);
    }

    public function update($id_order)
    {
        $Request = request();
        $request = $Request->all();
        $request['nominal'] = to_number($request['nominal']);
        // Validation
        $validation_rules = array(
            'nominal' => 'required|numeric',
            'products.*.qty' => 'required|numeric'
        );
        $validation_messages = array();
        $validation_messages['products.*.qty.numeric'] = str_replace(":attribute", "quantity", trans('validation.numeric'));
        $validation_messages['products.*.qty.required'] = str_replace(":attribute", "quantity", trans('validation.required'));
        $validator = Validator::make($request, $validation_rules, $validation_messages);
        if ($validator->fails()) {
            // Set parameters for HTTP Response
            $parameters = array(
                'status' => 400,
                'type' => "error",
                'errors' => $validator->errors()->messages()
            );
            // Send Response
            $Response = new JsonResponse($parameters, 400);
            $Response->send();
            exit;
        }
        // Delete products has been removed
        $OrderProductsModel = new OrderProducts;
        $id_products = array();
        foreach ($request['products'] as $product) {
            if ($product['id']) {
                $id_products[] = $product['id_product'];
            }
        }
        $OrderProductsModel->where('id_order', '=', $id_order)->whereNotIn('id_product', $id_products)->delete();
        $result = DB::transaction(function ($db) use ($id_order, $request) {
                    $ProductsModel = new Products;
                    $products = $ProductsModel->gets();
                    $subtotal = 0;
                    foreach ($request['products'] as $record) {
                        $id_product = $record['id_product'];
                        $product = $products[$id_product];
                        $price = $product['price'] * $record['qty'];
                        $subtotal += $price;
                    }
                    $tax = $subtotal * 10 / 100;
                    $total = $subtotal + $tax;
                    $change = $request['nominal'] - $total;
                    $parameters = array(
                        'id_user' => session('id'),
                        'subtotal' => $subtotal,
                        'ppn' => $tax,
                        'total' => $total,
                        'paid' => $request['nominal'],
                        'change' => $change,
                    );
                    // Insert order
                    $OrdersModel = new Orders;
                    $order = $OrdersModel->where('id', '=', $id_order)->update($parameters);
                    foreach ($request['products'] as $product) {
                        // Update order products
                        if ($product['id']) {
                            $parameters = array(
                                'qty' => $product['qty'],
                            );
                            $OrderProductsModel = new OrderProducts;
                            $order_product = $OrderProductsModel->where('id_order', '=', $id_order)
                                    ->where('id_product', '=', $product['id_product'])
                                    ->update($parameters);
                        } else {
                            // Insert order products
                            $parameters = array(
                                'id_order' => $id_order,
                                'id_product' => $product['id_product'],
                                'qty' => $product['qty'],
                            );
                            $OrderProductsModel = new OrderProducts;
                            $order_product = $OrderProductsModel->create($parameters);
                        }
                    }
                    return $order;
                });
        // Set parameters for HTTP Response
        $parameters = array(
            'status' => 200,
            'type' => "success",
            'message' => "Transaksi berhasil diperbaharui."
        );
        // Send Response
        $Response = new JsonResponse($parameters, 200);
        $Response->send();
        exit;
    }

    public function show($id)
    {
        // Render
        $ProductsModel = new Products;
        $products = $ProductsModel->gets();
        $order = Orders::gets($id);
        // Is valid record
        if (!$order) {
            // Redirect to List Page
            // Set session flash for notify Entry is not exist
            return redirect(action(config('app.backend_namespace') . 'OrdersController@index'))
                            ->with('dk_orders_info_error', trans('dkscaffolding.no.entry'));
        }
        $order_products = Orders::get_products($id);
        $parameters = array(
            'id_page' => "struk",
            'products' => $products,
            'order' => $order,
            'order_products' => $order_products,
        );
        $this->masterView = 'backend.themes.vish.struk';
        return $this->render($parameters);
    }

}
