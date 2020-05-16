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

class CartController extends FrontEndController
{

    /**
     * Cart Page
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
//        $cart = array(
//            1 => array(
//                'id' => 1,
//                'qty' => 1
//            ),
//            3 => array(
//                'id' => 1,
//                'qty' => 1
//            ),
//        );
//        $cart[1]['qty']++;
//        $parameters = array(
//            'id_customer' => 1,
//            'cart' => $cart,
//        );
//        session($parameters);
//        $cart = session('cart');
//        $cart[1]['qty'] = 5;
//        $parameters = array(
//            'cart' => $cart,
//        );
//        session($parameters);
//        dd(session('cart'));
//        dd(session('id_customer'));
        $cart = session('cart');
        if( !$cart ){
            return redirect(action(config('app.frontend_namespace') . 'HomePageController@index'));
        }
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
        $parameters = $this->getParameters();
        $parameters['id_page'] = "cart";
        $parameters['cart'] = $cart;
        $parameters['products'] = $products;
        return view('frontend.themes.ecommerce.cart', $parameters)->render();
    }

    /**
     * Process quantity of products
     * 
     * @return Illuminate\View\View
     */
    public function add()
    {
//        dd(session('cart'), session('id_customer'));
//        dd(request('product'));
        $cart = request('product');
        $parameters = array(
            'cart' => $cart,
        );
        session($parameters);
//        // Get product ids
//        $ids_product = array();
//        foreach ($cart as $id_product => $product) {
//            $ids_product[] = $id_product;
//        }
//        // Get product
//        $columns = array(
//            'products.*',
//            'categories.name AS category_name'
//        );
//        $Model = new Products;
//        $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
//                ->whereIn('products.id', $ids_product);
//        $products = $Model->select($columns)->get();
//        $parameters = $this->getParameters();
//        $parameters['id_page'] = "cart";
//        $parameters['cart'] = $cart;
//        $parameters['products'] = $products;
//        return view('frontend.themes.ecommerce.cart', $parameters)->render();
        return redirect(action(config('app.frontend_namespace') . 'DeliveryInfoController@index'));
    }

}
