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

class CategoryController extends FrontEndController
{

    /**
     * Category Page
     * 
     * @return Illuminate\View\View
     */
    public function index($category_name)
    {
        $category_name = str_replace("-", " ", $category_name);
        // Get categories
        $categories = Categories::gets();
        // Get category
        $Model = new Categories;
        $category = $Model->where('name', '=', $category_name)->first();
        // Get products
        $columns = array(
            'products.*'
        );
        $Model = new Products;
        $Model = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER');
        $Model = $Model->where('categories.name', '=', $category_name);
        $products = $Model->orderBy('products.id', 'ASC')->select($columns)->get();
        $parameters = $this->getParameters();
        $parameters['id_page'] = "category";
        $parameters['categories'] = $categories;
        $parameters['category'] = $category;
        $parameters['products'] = $products;
        return view('frontend.themes.ecommerce.category', $parameters)->render();
    }

}
