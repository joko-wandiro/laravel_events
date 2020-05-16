<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Route;
use Gate;

//use Illuminate\Routing\Router as Route;

class Authorization
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cashier_routes = array(
            'backend.logout',
            'orders.create',
            'orders.store',
            'users.edit',
            'users.update',
        );
        $route_name = Route::currentRouteName();
        $route_names = explode(".", $route_name);
        // Get relevant route for scaffolding
        if (request('identifier')) {
            $httpVerb = request()->getMethod();
            switch ($httpVerb) {
                case "POST":
                    $action = "store";
                    break;
                case "PUT":
                    $action = "update";
                    break;
                case "DELETE":
                    $action = "delete";
                    break;
                case "GET":
                    $action = request('action');
                    break;
            }
            $route_names[1] = $action;
            $route_name = implode(".", $route_names);
        }
        if (session('id_user_type') == 2) {
            // Checking route is valid
            if (!in_array($route_name, $cashier_routes)) {
                abort(403);
            }
        }

        return $next($request);
    }

}
