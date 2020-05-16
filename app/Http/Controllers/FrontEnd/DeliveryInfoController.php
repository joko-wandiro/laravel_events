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

class DeliveryInfoController extends FrontEndController
{

    /**
     * Cart Page
     * 
     * @return Illuminate\View\View
     */
    public function index()
    {
        $delivery_info = session('delivery_info');
//        $cart = session('cart');
//        dd($cart);
//        $httpVerb = request()->getMethod();
//        $Scaffolding = new Scaffolding("customers");
//        switch ($httpVerb) {
//            case "POST":
//                // Set password
//                $Scaffolding->addHooks("insertModifyRequest", array($this, "setPassword"));
//                // Hook Filter insertModifyResponse to modify response
//                $Scaffolding->addHooks("insertModifyResponse", array($this, "insertModifyResponse"));
//                $Scaffolding->processInsert();
//                break;
//        }
//        $Scaffolding->setTemplate('frontend.themes.standard.comment');
//        // Modify form layout
//        $Scaffolding->addHooks("modifyLayout", array($this, "modifyLayout"));
//        // Modify properties of columns
//        $Scaffolding->addHooks("modifyColumnsProperties", array($this, "modifyColumnsProperties"));
//        // Modify validation rules
//        $Scaffolding->addHooks("insertModifyValidationRules", array($this, "modifyValidation"));
//        $Scaffolding->addHooks("modifyValidationRulesJS", array($this, "modifyValidationRulesJS"));
//        $customerForm = $Scaffolding->renderCreate();
        $parameters = $this->getParameters();
        $parameters['id_page'] = "delivery-info";
        $parameters['delivery_info'] = $delivery_info;
//        $parameters['customer_form'] = $customerForm;
        return view('frontend.themes.ecommerce.delivery_info', $parameters)->render();
    }

    /**
     * Process quantity of products
     * 
     * @return Illuminate\View\View
     */
    public function save()
    {
//        dd(session('cart'), session('id_customer'));
//        dd(request('product'));
//        $delivery_info = request()->all();
//        dd($delivery_info);
        $rules = array(
            'name' => 'max:255|string|required',
            'phone' => 'max:255|string|required',
            'address' => 'required',
        );
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $parameters = array(
            'delivery_info' => array(
                'name' => request('name'),
                'phone' => request('phone'),
                'address' => request('address'),
            ),
        );
        session($parameters);
        return redirect(action(config('app.frontend_namespace') . 'PaymentController@index'));
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
