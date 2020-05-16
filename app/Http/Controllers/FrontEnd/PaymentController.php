<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Auth;
use MenuBuilder;
use Route;
use App\Models\Categories;
use App\Models\Products;
use DB;
use Scaffolding;
use Form;
use Validator;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\OrderProducts;

class PaymentController extends FrontEndController
{

    /**
     * Cart Page
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        $delivery_info = session('delivery_info');
        $cart = session('cart');
        // Get product ids
        $ids_product = array();
        foreach ($cart as $id_product => $product) {
            $ids_product[] = $id_product;
        }
        // Get product
        $columns = array(
            'products.*',
            'categories.name AS category_name'
        );
        $Model = new Products;
        $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
                ->whereIn('products.id', $ids_product);
        $products = $Model->select($columns)->get();
//        dd($address);
        $parameters = $this->getParameters();
        $parameters['id_page'] = "payment";
        $parameters['cart'] = $cart;
        $parameters['products'] = $products;
        $parameters['delivery_info'] = $delivery_info;
//        $parameters['customer_form'] = $customerForm;
        return view('frontend.themes.ecommerce.payment', $parameters)->render();
    }

    /**
     * Process quantity of products
     * 
     * @return Illuminate\View\View
     */
    public function save()
    {
        $result = DB::transaction(function ($db) {
                    $delivery_info = session('delivery_info');
                    $cart = session('cart');
                    // Get product ids
                    $ids_product = array();
                    foreach ($cart as $id_product => $product) {
                        $ids_product[] = $id_product;
                    }
                    // Get product
                    $columns = array(
                        'products.*',
                        'categories.name AS category_name'
                    );
                    $Model = new Products;
                    $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
                            ->whereIn('products.id', $ids_product);
                    $products = $Model->select($columns)->get();
                    $total = 0;
                    foreach ($products as $product) {
                        $id_product = $product['id'];
                        $qty = $cart[$id_product]['qty'];
                        $subtotal = $product['price'] * $qty;
                        $total += $subtotal;
                    }
                    $delivery_fee = 10000;
                    $total_delivery = $total + $delivery_fee;
                    $ppn = $total_delivery * 10 / 100;
                    $grand_total = $total_delivery + $ppn;
                    // Insert order
                    $parameters = array(
                        'subtotal' => $total,
                        'delivery_fee' => $total_delivery,
                        'ppn' => $ppn,
                        'total' => $grand_total,
                    );
                    $Orders = new Orders;
                    $Orders = $Orders->create($parameters);
                    // Insert order detail
                    $parameters = array(
                        'id_order' => $Orders->id,
                        'name' => $delivery_info['name'],
                        'phone' => $delivery_info['phone'],
                        'address' => $delivery_info['address'],
                    );
                    $OrderDetail = new OrderDetail;
                    $OrderDetail = $OrderDetail->create($parameters);
                    // Insert order products
                    foreach ($cart as $id_product => $product) {
                        $parameters = array(
                            'id_order' => $Orders->id,
                            'id_product' => $product['id'],
                            'qty' => $product['qty'],
                        );
                        $OrderProducts = new OrderProducts;
                        $OrderProducts = $OrderProducts->create($parameters);
                    }
                    return $Orders;
                });
        return redirect(action(config('app.frontend_namespace') . 'OrderController@index', array('id_order'=>$result->id)));
    }

    /**
     * Add comment response
     * 
     * @return Illuminate\View\View
     */
    public function insertModifyResponse($Response)
    {
        return back()->with('alert_success_customers', trans('main.alert.success.customers'));
    }

    /**
     * Modify properties of columns
     * 
     * @param  array $columns
     * 
     * @return  array
     */
    public function modifyColumnsProperties($columns)
    {
        $action = request()->action;
        $columns['password_confirm'] = array(
            'attributes' => array(
                'class' => 'form-control dk-character',
                'placeholder' => 'Password',
            ),
            'name' => 'password_confirm',
            'label' => trans('dkscaffolding.column.password_confirm'),
            'dataType' => 'VARCHAR',
            'length' => '255',
            'range' => NULL,
            'type' => 'password',
            'require' => true,
        );
        if ($action == "edit") {
            $columns['password']['require'] = false;
            $columns['password_confirm']['require'] = false;
        }
        return $columns;
    }

    /**
     * Modify form layout
     * 
     * @param  array $layout
     * 
     * @return  array
     */
    public function modifyLayout($layout)
    {
        $password_confirm = array(
            array(
                array(
                    'attributes' => array(
                        'class' => 'col-sm-12',
                    ),
                    'name' => 'password_confirm',
                ),
            )
        );
        array_splice($layout, 3, 0, $password_confirm);
        return $layout;
    }

    /**
     * Modify javascript validation rules
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function modifyValidationRulesJS($rules)
    {
        $action = request()->action;
        if ($action == "edit") {
            unset($rules['password']['required']);
        }
        $rules['password_confirm']['equalTo'] = ":input[name=\"password\"]";
        return $rules;
    }

    /**
     * Modify validation
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function modifyValidation($rules)
    {
        $httpVerb = request()->getMethod();
        $rules['password_confirm'] = 'max:255|string|required|same:password';
        if ($httpVerb == "PUT" || $httpVerb == "PATCH") {
            $rules['password'] = 'max:255|string|nullable';
            $rules['password_confirm'] = 'max:255|string|nullable|same:password';
        }
        return $rules;
    }

    /**
     * Set image column
     * 
     * @param array $parameters
     * 
     * @return array
     */
    public function setPassword($parameters)
    {
        $httpVerb = request()->getMethod();
        if (($httpVerb == "PUT" || $httpVerb == "PATCH") && !$parameters['password']) {
            unset($parameters['password']);
        }
        if (isset($parameters['password'])) {
            $parameters['password'] = password_hash($parameters['password'], PASSWORD_DEFAULT);
        }
        return $parameters;
    }

}
