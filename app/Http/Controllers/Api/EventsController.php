<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;
use Html;
use DB;

class EventsController extends ApiController
{

    protected $table = 'events';

    /**
     * Display specific post
     *
     * @return Illuminate\View\View
     */
    public function event($title)
    {
        $title = str_replace("-", " ", $title);
        // Set request uri parameters
        $Request = request();
        $Request->query->set('action', 'view');
        $Request->query->set('indexes', array(
            'title' => $title
        ));
        $this->index();
    }

    /**
     * Posts Page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $Request = request();
        $Request->query->set('identifier', 'events');
        $Scaffolding = clone $this->scaffolding;
        // Modify query for View Action
        $Scaffolding->addHooks("viewPrepareRecord", array($this, "viewPrepareRecord"));
        // Modify record for View Action
        $Scaffolding->addHooks("viewModifyRecord", array($this, "viewModifyRecord"));
        // Modify record for ListView
        $Scaffolding->addHooks("listModifyRecord", array($this, "listModifyRecord"));
        $Scaffolding->orderBy("events.updated_at", "DESC");
        $records_per_pages = array(
            8 => sprintf(trans('dkscaffolding.show.entries'), 8),
        );
        $Scaffolding->setListOfRecordsPerPage($records_per_pages);
        $Scaffolding->setContentType('json')->render();
    }

    /**
     * Hook Filter - Modify record for View Action
     * 
     * @param \App\Libraries\Scaffolding\Model $model
     * 
     * @return void
     */
    public function viewPrepareRecord($Model)
    {
        $columns = array('events.*', 'organizers.name');
        return $Model->select($columns)->join('organizers', 'organizers.id', '=', 'events.id_organizer', 'INNER');
    }

    /**
     * Hook Filter - Modify record for View Action
     * 
     * @param \App\Libraries\Scaffolding\Model $model
     * 
     * @return void
     */
    public function viewModifyRecord($record)
    {
        $record['image'] = image_url_medium($record['image']);
        $record['start_date'] = get_date_indonesian_format($record['start_date']);
        $record['end_date'] = get_date_indonesian_format($record['end_date']);
        $record['start_time'] = get_time_indonesian_format($record['start_time']);
        $record['end_time'] = get_time_indonesian_format($record['end_time']);
        return $record;
    }

    /**
     * Formatter for ListView
     * 
     * @param \App\Libraries\Scaffolding\Model $model
     * 
     * @return void
     */
    public function listModifyRecord($records)
    {
        $result = array();
        foreach ($records as $record) {
            $record['url'] = url(to_url_component($record['events.title']));
            $record['events.image'] = image_url_medium($record['events.image']);
            $record['events.start_date'] = get_date_indonesian_format($record['events.start_date']);
            $record['events.end_date'] = get_date_indonesian_format($record['events.end_date']);
            $record['events.start_time'] = get_time_indonesian_format($record['events.start_time']);
            $record['events.end_time'] = get_time_indonesian_format($record['events.end_time']);
            unset($record['actions']);
            $result[] = $record;
        }
        return $result;
    }

}
