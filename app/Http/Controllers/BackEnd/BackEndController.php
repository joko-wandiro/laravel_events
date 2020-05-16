<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Auth;
use MenuBuilder;
use Route;
use Form;
use Illuminate\Http\JsonResponse;
use Scaffolding;
use App\Models\Settings;
use App;

class BackEndController extends Controller
{

    protected $js = array();
    protected $jsParameters = array();
    protected $css = array();
    protected $masterView = 'backend.themes.vish.index';
//    protected $masterView = 'backend.themes.standard.index';
    protected $scaffolding;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('backend.auth');
        $this->middleware('backend.authorization');
        // Add css files
        $this->addCSS('font.awesome', 'css/font-awesome.min.css');
        $this->addCSS('bootstrap', 'css/bootstrap.min.css');
        $this->addCSS('dkscaffolding', 'css/vishscaffolding.css');
        $this->addCSS('ie10', 'css/ie10-viewport-bug-workaround.css');
        $this->addCSS('themes', 'css/themes/vish/theme.css');
        $this->addCSS('responsive', 'css/themes/vish/responsive.css');
        // Add javascript files
        $this->addJS('jquery', 'js/jquery.min.js');
        $this->addJS('jquery.blockUI', 'js/jquery.blockUI.js');
        $this->addJS('bootstrap', 'js/bootstrap.min.js');
        $this->addJS('jquery.validate', 'js/jquery.validate.min.js');
        $this->addJS('jquery.validate.additional', 'js/additional-methods.min.js');
        $this->addJS('ie10', 'js/ie10-viewport-bug-workaround.js');
        $this->addJS('zerobox', 'js/zerobox.js');
        $this->addJS('dkscaffolding', 'js/jquery.dkscaffolding.js');
        $this->addJS('site', 'js/backend/site.js');
        $this->addJS('main', 'js/themes/vish/main.js');
        // Get settings value
        $settings = Settings::get_parameters();
        $GLOBALS['settings'] = $settings;
        $this->jsParameters['settings'] = $settings;
        // Set default parameters for Scaffolding
        $this->scaffolding = new Scaffolding($this->table);
        $this->scaffolding->setTemplate("vishscaffolding");
    }

    /**
     * Actions column
     * 
     * @param  \App\Libraries\Scaffolding\Model $record
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  void
     */
    public function getParameters()
    {
        $id_user_type = session('id_user_type');
        if ($id_user_type == 2) {
            $records = array(
                array(
                    'id' => 1,
                    'name' => trans('main.pos'),
                    'url' => action(config('app.backend_namespace') . 'PosController@create'),
                    'icon' => 'fa fa-truck',
                    'parentID' => 0,
                    'order' => 1,
                ),
            );
        } else {
            $date = date("Y-m");
            $dates = explode("-", $date);
            $records = array(
                array(
                    'id' => 1,
                    'name' => trans('main.tags'),
                    'url' => action(config('app.backend_namespace') . 'TagsController@index'),
                    'parentID' => 0,
                    'order' => 1,
                ),
                array(
                    'id' => 2,
                    'name' => trans('main.organizers'),
                    'url' => action(config('app.backend_namespace') . 'OrganizersController@index'),
                    'parentID' => 0,
                    'order' => 2,
                ),
                array(
                    'id' => 3,
                    'name' => trans('main.events'),
                    'url' => action(config('app.backend_namespace') . 'EventsController@index'),
                    'parentID' => 0,
                    'order' => 4,
                ),
                array(
                    'id' => 4,
                    'name' => trans('main.users'),
                    'url' => action(config('app.backend_namespace') . 'UsersController@index'),
                    'parentID' => 0,
                    'order' => 4,
                ),
                array(
                    'id' => 5,
                    'name' => trans('main.settings'),
                    'url' => action(config('app.backend_namespace') . 'SettingsController@edit'),
                    'parentID' => 0,
                    'order' => 3,
                ),
                array(
                    'id' => 9,
                    'name' => trans('main.list'),
                    'url' => action(config('app.backend_namespace') . 'TagsController@index'),
                    'parentID' => 1,
                    'order' => 1,
                ),
                array(
                    'id' => 10,
                    'name' => trans('main.create'),
                    'url' => action(config('app.backend_namespace') . 'TagsController@index', array('action' => 'create', 'identifier' => 'tags')),
                    'parentID' => 1,
                    'order' => 2,
                ),
                array(
                    'id' => 11,
                    'name' => trans('main.list'),
                    'url' => action(config('app.backend_namespace') . 'OrganizersController@index'),
                    'parentID' => 2,
                    'order' => 1,
                ),
                array(
                    'id' => 12,
                    'name' => trans('main.create'),
                    'url' => action(config('app.backend_namespace') . 'OrganizersController@index', array('action' => 'create', 'identifier' => 'organizers')),
                    'parentID' => 2,
                    'order' => 2,
                ),
                array(
                    'id' => 12,
                    'name' => trans('main.list'),
                    'url' => action(config('app.backend_namespace') . 'EventsController@index'),
                    'parentID' => 3,
                    'order' => 1,
                ),
                array(
                    'id' => 13,
                    'name' => trans('main.create'),
                    'url' => action(config('app.backend_namespace') . 'EventsController@index', array('action' => 'create', 'identifier' => 'events')),
                    'parentID' => 3,
                    'order' => 2,
                ),
                array(
                    'id' => 14,
                    'name' => trans('main.list'),
                    'url' => action(config('app.backend_namespace') . 'UsersController@index'),
                    'parentID' => 4,
                    'order' => 1,
                ),
                array(
                    'id' => 15,
                    'name' => trans('main.create'),
                    'url' => action(config('app.backend_namespace') . 'UsersController@index', array('action' => 'create', 'identifier' => 'users')),
                    'parentID' => 4,
                    'order' => 2,
                ),
            );
        }
        $menuAttributes = array('class' => 'nav navbar-nav');
        $dropdownListAttributes = array('class' => 'dropdown');
        $dropdownMenuAttributes = array('class' => 'dropdown-menu');
        $dropdownLinkAttributes = array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown');
        $MenuBuilder = new MenuBuilder($records);
        $menu = $MenuBuilder->setMenuAttributes($menuAttributes)->setCurrentUrl(request()->getUri())->setDropdownListAttributes($dropdownListAttributes)->setDropdownLinkAttributes($dropdownLinkAttributes)->setDropdownMenuAttributes($dropdownMenuAttributes)->setDropdownListElement('<span class="caret"></span>')->setDropdownListElementAttributes(array())->get();
        $breadcrumb = $MenuBuilder->getSelectedMenu();
        $Route = Route::current();
        $this->jsParameters['formAction'] = action("\\" . $Route->getActionName(), $Route->parameters());
        $this->jsParameters['confirmDeleteMessage'] = trans('main.confirm.box.delete');
        $this->jsParameters['action'] = request()->action;
        if (isset($this->table)) {
            $this->jsParameters['tableIdentifier'] = $this->table;
        }
        $parameters = array(
            'menu' => $menu,
            'breadcrumb' => $breadcrumb,
            'js' => $this->js,
            'jsParameters' => $this->jsParameters,
            'css' => $this->css,
            'id_page' => "",
        );
        return $parameters;
    }

    /**
     * Add a javascript file
     * 
     * @param string $name
     * @param string $src
     * 
     * @return void
     */
    public function addJS($name, $src)
    {
        $this->js[$name] = $src;
    }

    /**
     * Remove a javascript file
     * 
     * @param string $name
     * 
     * @return void
     */
    public function removeJS($name)
    {
        unset($this->js[$name]);
    }

    /**
     * Add a css file
     * 
     * @param string $name
     * @param string $src
     * 
     * @return void
     */
    public function addCSS($name, $src)
    {
        $this->css[$name] = $src;
    }

    /**
     * Remove a css file
     * 
     * @param string $name
     * 
     * @return void
     */
    public function removeCSS($name)
    {
        unset($this->css[$name]);
    }

    /**
     * Actions column
     * 
     * @param  \App\Libraries\Scaffolding\Model $record
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  void
     */
    public function actionColumn($record, $Scaffolding)
    {
        $url = $Scaffolding->getActionButtonUrls($record);
        echo '<div class="text-center">
	    <a href="' . $url['edit'] . '" class="btn btn-edit btn-blue" title="' . trans('main.edit') . '"><i class="fa fa-edit"></i></a>
	    <a href="' . $url['delete'] . '" class="btn btn-remove btn-blue" data-id="' .
        $record['id'] . '" title="' . trans('main.remove') . '"><i class="fa fa-trash"></i></a>
	    </div>';
    }

    /**
     * Actions column
     * 
     * @param  \App\Libraries\Scaffolding\Model $record
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  void
     */
    public function render($arguments)
    {
        $parameters = $this->getParameters();
        $parameters = array_merge($parameters, $arguments);
        return view($this->masterView, $parameters);
    }

    /**
     * Set Response for AJAX delete operation
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function deleteModifyResponse($Response)
    {
        $Request = request();
        if ($Request->ajax()) {
            // Set parameters for HTTP Response
            $parameters = array(
                'status' => 1,
                'type' => "success",
                'msg' => trans("main.delete.success"),
            );
            // Send Response
            $Response = new JsonResponse($parameters, 200);
            $Response->send();
            exit;
        }
    }

}
