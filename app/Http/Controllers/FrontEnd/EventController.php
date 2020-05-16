<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Auth;
use MenuBuilder;
use Route;
use App\Models\Posts;
use App\Models\Comments;
use App\Models\Categories;
use App\Models\Tags;
use App\Models\Pages;
use App\Models\Settings;
use DB;
use Scaffolding;
use Form;

class EventController extends FrontEndController
{

    /**
     * Home Page
     * 
     * @return Illuminate\View\View
     */
    public function index($title)
    {
        $title = str_replace("-", " ", $title);
        // Set request uri parameters
        $Request = request();
        $Request->query->set('identifier', 'events');
        $Request->query->set('action', 'view');
        $Request->query->set('indexes', array(
            'title' => $title
        ));
        // Scaffolding
        $Scaffolding = new Scaffolding("events");
        $Scaffolding->addHooks("prepareRecord", array($this, "prepareRecord"));
        $Scaffolding->setTemplate("events");
        $content = $Scaffolding->render();
        $parameters = $this->getParameters();
        $parameters['page'] = "event-page";
        $parameters['scaffolding'] = $content;
        return view('frontend.themes.events.index', $parameters);
    }

    /**
     * Get form input tags
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\Scaffolding $Scaffolding
     * 
     * @return  string
     */
    public function prepareRecord($Model)
    {
        $columns = array('events.*', 'organizers.name');
        return $Model->select($columns)->join('organizers', 'organizers.id', '=', 'events.id_organizer', 'INNER');
    }

}
