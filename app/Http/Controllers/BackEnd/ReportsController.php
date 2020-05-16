<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scaffolding;
use Form;
use DB;
use Validator;
use App\Models\Orders;

class ReportsController extends BackEndController
{

    protected $table = 'settings';

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
    }

    public function daily($year, $month)
    {
        $month_year = $year . "-" . $month;
        // Get daily order
        $orders = Orders::get_daily_orders($year, $month);
//        dd($orders);
        $parameters = array(
            'id_page' => "reports-daily",
            'year' => $year,
            'month' => $month,
            'orders' => $orders,
        );
        $this->masterView = 'backend.themes.vish.daily';
        return $this->render($parameters);
    }

    public function monthly($year)
    {
        $year = ($year < 1) ? "2019" : $year;
        // Get monthly order
        $orders = Orders::get_monthly_orders($year);
//        dd($orders);
        $parameters = array(
            'id_page' => "reports-daily",
            'year' => $year,
            'orders' => $orders,
        );
        $this->masterView = 'backend.themes.vish.monthly';
        return $this->render($parameters);
    }

}
