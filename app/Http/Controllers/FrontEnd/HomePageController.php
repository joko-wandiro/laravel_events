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

class HomePageController extends FrontEndController
{

    /**
     * Home Page
     * 
     * @return Illuminate\View\View
     */
    public function index($page = 1)
    {
        $page = (int) $page;
        // Set request uri parameters
        $Request = request();
        $Request->query->set('identifier', 'events');
        $Request->query->set('page', $page);
        // Scaffolding
        $records_per_pages = array(
            8 => sprintf(trans('dkscaffolding.show.entries'), 8),
        );
        $Scaffolding = new Scaffolding("events");
        $Scaffolding->setTemplate("events");
        $Scaffolding->setListOfRecordsPerPage($records_per_pages);
        $content = $Scaffolding->render();
        $parameters = $this->getParameters();
        $parameters['page'] = "homepage";
        $parameters['scaffolding'] = $content;
        return view('frontend.themes.events.index', $parameters);
    }

}
