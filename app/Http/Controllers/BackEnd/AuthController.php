<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Validator;
use DB;
use BackAuth;
use Route;
use App\Models\Settings;

class AuthController extends Controller
{

    protected $redirect = 'DashboardController@index';

//    protected $redirect = 'CategoriesController@index';

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        // Get settings value
        $settings = Settings::get_parameters();
        $GLOBALS['settings'] = $settings;
    }

    public function displayLoginForm()
    {
        if (self::check()) {
            // If authenticated user redirect to BackEnd
            return redirect(action(config('app.backend_namespace') . $this->redirect));
        }
        return view('backend.auth.login');
    }

    public function login()
    {
        $Request = request();
        // Validate Request
        $validationRules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = Validator::make($Request->all(), $validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Authenticate
        $Model = new \App\Models\Users;
        $record = $Model->where('email', '=', $Request['email'])->first();
        if (password_verify($Request['password'], $record['password'])) {
            // Set session parameters
            $parameters = array(
                'id' => $record['id'],
                'id_user_type' => $record['id_user_type'],
                'admin' => $record['email'],
                'idle_time' => time(),
            );
            session($parameters);
            // Set redirect for cashier or admin
            $controller = ($record['id_user_type'] == 2) ? 'PosController@create' : $this->redirect;
            return redirect(action(config('app.backend_namespace') . $controller));
        } else {
            return back()->with('login_failure', trans('form.login.failure'));
        }
    }

    public function logout()
    {
        return self::doLogout();
    }

    public static function doLogout()
    {
        session()->flush();
        return redirect(action(config('app.backend_namespace') . 'AuthController@displayLoginForm'));
    }

    public static function check()
    {
        return ( session('admin') ) ? TRUE : FALSE;
    }

}
