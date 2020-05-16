<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;
use App\Models\Products;
use App\Models\ExitGoodsDetail;
use App\Models\Warehouses;
use DB;

class OrdersController extends BackEndController
{

    protected $table = 'orders';

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct_()
    {
        parent::__construct();
        $this->js = array();
        $this->css = array();
        // Add css files
        $this->addCSS('font.awesome', 'css/font-awesome.min.css');
        $this->addCSS('jquery.ui', 'css/jquery-ui.css');
        $this->addCSS('bootstrap', 'css/bootstrap.min.css');
        $this->addCSS('dkscaffolding', 'css/seascaffolding.css');
        $this->addCSS('ie10', 'css/ie10-viewport-bug-workaround.css');
        $this->addCSS('themes', 'css/themes/sea/theme.css');
        $this->addJS('jquery', 'js/jquery.min.js');
        $this->addJS('jquery.ui', 'js/jquery-ui.min.js');
        $this->addJS('jquery.blockUI', 'js/jquery.blockUI.js');
        $this->addJS('bootstrap', 'js/bootstrap.min.js');
        $this->addJS('jquery.validate', 'js/jquery.validate.min.js');
        $this->addJS('ie10', 'js/ie10-viewport-bug-workaround.js');
        $this->addJS('zerobox', 'js/zerobox.js');
        $this->addJS('zerovalidation', 'js/zerovalidation.js');
        $this->addJS('zeromask', 'js/zeromask.js');
        $this->addJS('dkscaffolding', 'js/jquery.dkscaffolding.js');
        $this->addJS('site', 'js/backend/site.js');
        $this->addJS('main', 'js/themes/vish/main.js');
    }

    /**
     * Build order page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $Scaffolding = clone $this->scaffolding;
        $Scaffolding->join('users', 'users.id', '=', 'orders.id_user', 'INNER');
        // Set columns properties
        $parameters = array(
            array(
                'name' => 'DATE_FORMAT(date, "%d %M %Y") AS date',
                'width' => '15%',
            ),
            array(
                'name' => 'users.name',
                'width' => '40%',
            ),
            array(
                'name' => 'total',
                'width' => '20%',
            ),
            // Add Actions custom column
            array(
                'name' => 'xaction',
                'label' => '&nbsp;',
                'width' => '15%',
                'callback' => array($this, 'action_column'),
            ),
        );
        $Scaffolding->setColumnProperties($parameters);
        $visibility = array(
            'create_button' => FALSE,
        );
        $Scaffolding->setVisibilityListElements($visibility);
        // Set formatter for image column
        $Scaffolding->addFormatterColumn('total', array($this, 'formatter_total'));
        // Hooks Action for delete operation ( AJAX Request )
        $Scaffolding->addHooks("deleteModifyResponse", array($this, "deleteModifyResponse"));
        $content = $Scaffolding->render();
        $parameters = array(
            'scaffolding' => $content,
        );
        return $this->render($parameters);
    }

    /**
     * Formatter for total column
     * 
     * @param  \App\Libraries\Scaffolding\Model $model
     * 
     * @return  void
     */
    public function formatter_total($model)
    {
        echo getThousandFormat($model['total']);
    }

    /**
     * Actions column
     * 
     * @param  \App\Libraries\Scaffolding\Model $record
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  void
     */
    public function action_column($record, $Scaffolding)
    {
        $url = $Scaffolding->getActionButtonUrls($record);
        $url_view = action(config('app.backend_namespace') . 'PosController@show', array('id' => $record['id']));
        $url_view .= "?action=view";
        $url_edit = action(config('app.backend_namespace') . 'PosController@edit', array('id' => $record['id']));
        echo '<div class="text-center">
            <a href="' . $url_view . '" class="btn btn-view btn-blue" title="' . trans('main.view') . '"><i class="fa fa-file"></i></a>
	    <a href="' . $url_edit . '" class="btn btn-edit btn-blue" title="' . trans('main.edit') . '"><i class="fa fa-edit"></i></a>
	    <a href="' . $url['delete'] . '" class="btn btn-remove btn-blue" data-id="' .
        $record['id'] . '" title="' . trans('main.remove') . '"><i class="fa fa-trash"></i></a>
	    </div>';
    }

}
