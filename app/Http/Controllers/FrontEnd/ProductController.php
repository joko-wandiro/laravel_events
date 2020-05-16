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

class ProductController extends FrontEndController
{

    /**
     * Product Page
     * 
     * @return Illuminate\View\View
     */
    public function index($product_name)
    {
        $product_name = str_replace("-", " ", $product_name);
        // Get categories
        $categories = Categories::gets();
        // Get product
        $columns = array(
            'products.*',
            'categories.name AS category_name'
        );
        $Model = new Products;
        $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
                ->where('products.name', '=', $product_name);
        $product = $Model->select($columns)->get()->first();
        $parameters = $this->getParameters();
        $parameters['id_page'] = "product";
        $parameters['categories'] = $categories;
        $parameters['product'] = $product;
        return view('frontend.themes.ecommerce.product', $parameters)->render();
    }

    /**
     * Process quantity of products
     * 
     * @return Illuminate\View\View
     */
    public function add()
    {
//        dd(request()->all());
        $request = request()->all();
        $cart = session('cart');
        $cart[$request['id']] = array(
            'id' => $request['id'],
            'qty' => $request['qty'],
        );
        $parameters = array(
            'cart' => $cart,
        );
//        dd($parameters);
        session($parameters);
//        dd(session('cart'), session('id_customer'));
//        dd(request('product'));
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
        return back();
//        return redirect(action(config('app.frontend_namespace') . 'DeliveryInfoController@index'));
    }

}
