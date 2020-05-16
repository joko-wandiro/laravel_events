<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;
use DB;
use Storage;
use App\Models\Events;
use App\Models\Organizers;

class DashboardController extends BackEndController
{

    protected $table = 'events';
    protected $masterView = 'backend.themes.vish.dashboard';

    /**
     * Build products page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $events = Events::get_total_events();
        $organizers = Organizers::get_total_organizers();
        $parameters = array(
            'id_page' => "dashboard",
            'events' => $events,
            'organizers' => $organizers,
        );
        return $this->render($parameters);
    }

}
