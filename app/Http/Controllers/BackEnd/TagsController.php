<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;
use Illuminate\Http\JsonResponse;

class TagsController extends BackEndController
{

    protected $table = 'tags';

    /**
     * Build tags page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $Scaffolding = clone $this->scaffolding;
        // Set columns properties
        $parameters = array(
            array(
                'name' => 'name',
                'width' => '80%',
            ),
            // Add Actions custom column
            array(
                'name' => 'xaction',
                'label' => 'Actions',
                'width' => '20%',
                'callback' => array($this, 'actionColumn'),
            ),
        );
        $Scaffolding->setColumnProperties($parameters);
        $content = $Scaffolding->render();
        $parameters = array(
            'scaffolding' => $content,
        );
        return $this->render($parameters);
    }

}
