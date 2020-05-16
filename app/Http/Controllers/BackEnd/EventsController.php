<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Html;
use Form;
use App\Models\Organizers;
use App\Models\Tags;
use App\Models\EventTags;
use Intervention\Image\ImageManagerStatic as Image;

class EventsController extends BackEndController
{

    protected $table = 'events';
    protected $image_old;

    /**
     * Build products page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $organizers_list = Organizers::get_list();
        $tags_list = Tags::get_list();
        $Scaffolding = $this->scaffolding;
        $Scaffolding->join('organizers', 'organizers.id', '=', 'events.id_organizer', 'INNER');
        // Define form input filler for category
        $Scaffolding->setFormInputFiller("id_organizer", $organizers_list);
        // Define form input filler for tags
        $Scaffolding->setFormInputFiller("tags[]", $tags_list);
        // Set columns properties
        $parameters = array(
            array(
                'name' => 'image',
                'width' => '20%',
                'order' => FALSE,
                'search' => FALSE,
            ),
            array(
                'name' => 'organizers.name AS organizer_name',
                'width' => '30%',
            ),
            array(
                'name' => 'title',
                'width' => '30%',
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
        // Modify validation rules
        $Scaffolding->addHooks("insertModifyValidationRules", array($this, "modifyValidation"));
        $Scaffolding->addHooks("updateModifyValidationRules", array($this, "modifyValidation"));
        $Scaffolding->addHooks("modifyValidationRulesJS", array($this, "modifyValidationRulesJS"));
        // Upload file to permanent folder
        $Scaffolding->addHooks("insertAfterInsert", array($this, "moveImage"));
        $Scaffolding->addHooks("updateAfterUpdate", array($this, "moveImage"));
        // Process tags
        $Scaffolding->addHooks("insertAfterInsert", array($this, "processTags"));
        $Scaffolding->addHooks("updateAfterUpdate", array($this, "processTags"));
        // Modify image form input
        $Scaffolding->setFormInput('image', array($this, 'getFormInputImage'));
        // Set formatter for image column
        $Scaffolding->addFormatterColumn('image', array($this, 'formatterImage'));
        // Modify start_date and end_date form input in View action
        $Scaffolding->setFormInput('start_date', array($this, 'getFormInputStartDate'));
        $Scaffolding->setFormInput('end_date', array($this, 'getFormInputEndDate'));
        $Scaffolding->setFormInput('start_time', array($this, 'getFormInputStartTime'));
        $Scaffolding->setFormInput('end_time', array($this, 'getFormInputEndTime'));
        // Modify tags[] form input
        $Scaffolding->setFormInput('tags[]', array($this, 'getFormInputTags'));
        // Hook Action to set image and datetime columns
        $Scaffolding->addHooks("insertModifyRequest", array($this, "modifyRequest"));
        $Scaffolding->addHooks("updateModifyRequest", array($this, "modifyRequest"));
        // Modify form layout
        $Scaffolding->addHooks("modifyLayout", array($this, "modifyFormLayout"));
        // Modify column properties
        $Scaffolding->addHooks("modifyColumnsProperties", array($this, "modifyFormColumns"));
        // Hooks Action for delete operation ( AJAX Request )
        $Scaffolding->addHooks("deleteModifyResponse", array($this, "deleteModifyResponse"));
        $content = $Scaffolding->render();
        $parameters = array(
            'scaffolding' => $content,
        );
        switch (request('action')) {
            case "create":
            case "edit":
                $this->masterView = 'backend.themes.vish.event';
                break;
        }
        return $this->render($parameters);
    }

    /**
     * Modify form columns
     * 
     * @param  array $columns
     * 
     * @return  array
     */
    public function modifyFormColumns($columns)
    {
        $columns['tags'] = array(
            'attributes' => array(
                'class' => 'form-control dk-number',
                'multiple' => 'multiple'
            ),
            'name' => 'tags[]',
            'label' => 'Tags',
            'dataType' => 'BIGINT',
            'length' => '20',
            'range' => 'unsigned',
            'type' => 'select',
            'require' => FALSE,
        );
        return $columns;
    }

    /**
     * Modify form layout
     * 
     * @param  array $layout
     * 
     * @return  array
     */
    public function modifyFormLayout($layout)
    {
        $tags = array(
            array(
                array(
                    'attributes' => array(
                        'class' => 'col-sm-12',
                    ),
                    'name' => 'tags',
                )
            )
        );
        array_splice($layout, 1, 0, $tags);
        return $layout;
    }

    /**
     * Get form input end_time
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputEndTime($column, $Scaffolding)
    {
        $columnName = $column['name'];
        $Model = $Scaffolding->getModel();
        if ($Model[$columnName]) {
            $Model[$columnName] = date("g:i A", strtotime($Model[$columnName]));
        }
        echo '<div class="input-group time" id="start-time">';
        echo Form::text($column['name'], null, $column['attributes']);
        echo '<span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>';
    }

    /**
     * Get form input start_time
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputStartTime($column, $Scaffolding)
    {
        $columnName = $column['name'];
        $Model = $Scaffolding->getModel();
        if ($Model[$columnName]) {
            $Model[$columnName] = date("g:i A", strtotime($Model[$columnName]));
        }
        echo '<div class="input-group time" id="start-time">';
        echo Form::text($column['name'], null, $column['attributes']);
        echo '<span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>';
    }

    /**
     * Get form input start_date
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputStartDate($column, $Scaffolding)
    {
        $columnName = $column['name'];
        $Model = $Scaffolding->getModel();
        if ($Model[$columnName]) {
            $Model[$columnName] = date("m/d/Y", strtotime($Model[$columnName]));
        }
        echo '<div class="input-group date" id="start-date">';
        echo Form::text($column['name'], null, $column['attributes']);
        echo '<span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>';
    }

    /**
     * Get form input end_date
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputEndDate($column, $Scaffolding)
    {
        $columnName = $column['name'];
        $Model = $Scaffolding->getModel();
        if ($Model[$columnName]) {
            $Model[$columnName] = date("m/d/Y", strtotime($Model[$columnName]));
        }
        echo '<div class="input-group date" id="end-date">';
        echo Form::text($column['name'], null, $column['attributes']);
        echo '<span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>';
    }

    /**
     * Formatter for image column
     * 
     * @param  \App\Libraries\Scaffolding\Model $model
     * 
     * @return  void
     */
    public function formatterImage($model)
    {
        if ($model['image']) {
            $pathinfos = pathinfo($model['image']);
            echo '<img src="' . eventsImageUrl($pathinfos['filename'] . '_small.' . $pathinfos['extension']) . '" width="200" />';
        } else {
            echo '-';
        }
    }

    /**
     * Get form input tags
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\Scaffolding $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputTags($column, $Scaffolding)
    {
        // Get tags
        $Model = clone $Scaffolding->getModel();
        $event_id = $Model['id'];
        $tags = array();
        if ($event_id) {
            $Model = new EventTags();
            $tags = $Model->where('event_id', '=', $event_id)->get()->pluck("tag_id")->all();
        }
        $filler = $Scaffolding->getFormInputFiller();
        $columnName = $column['name'];
        $values = isset($filler[$columnName]) ? $filler[$columnName] : array();
        $html = '<select name="' . $columnName . '" ' . Html::attributes($column['attributes']) . 'multiple="multiple">';
        foreach ($values as $key => $value) {
            $selected = ( in_array($key, $tags) ) ? 'selected="selected"' : "";
            $html .= '<option value="' . $key . '"' . $selected . '>' . e($value) . '</option>';
        }
        $html .= '</select>';
        echo $html;
    }

    /**
     * Process tags
     * 
     * @param  array $columns
     * 
     * @return  array
     */
    public function processTags($Model)
    {
        $id_event = $Model['id'];
        $parameters = request()->all();
        if (isset($parameters['tags'])) {
            $Model = new EventTags;
            // Delete previous tags
            $ModelDelete = clone $Model;
            $ModelDelete->where('event_id', '=', $id_event)->delete();
            // Insert tags
            foreach ($parameters['tags'] as $id_tag) {
                $parameters = array(
                    'event_id' => $id_event,
                    'tag_id' => $id_tag,
                );
                $Model->create($parameters);
            }
        }
    }

    /**
     * Move image
     * 
     * @param array $parameters
     * 
     * @return array
     */
    public function moveImage($Model)
    {
        $Request = request();
//        $old = unserialize($Request['idx_old']);
        $filename = null;
        $hasImage = $Request->hasFile('image');
        if ($hasImage) {
            // Move image file to permanent directory
            $image_path = eventsImagePath($Model->image);
            rename(eventsImageTemporaryPath($Model->image), $image_path);
            $pathinfos = pathinfo($image_path);
            // Small size
            Image::make($image_path)->resize(settings('image_size_small_width'), null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(eventsImagePath($pathinfos['filename'] . '_small.' . $pathinfos['extension']));
            // Medium size
            Image::make($image_path)->resize(settings('image_size_medium_width'), null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(eventsImagePath($pathinfos['filename'] . '_medium.' . $pathinfos['extension']));
            // Resize image
            Image::make($image_path)->resize(1110, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($image_path);
            // Delete previous file
            if ($Model['image']) {
                $pathinfos = pathinfo($this->image_old);
                unlink(eventsImagePath($this->image_old));
                unlink(eventsImagePath($pathinfos['filename'] . '_small.' . $pathinfos['extension']));
                unlink(eventsImagePath($pathinfos['filename'] . '_medium.' . $pathinfos['extension']));
            }
        }
    }

    /**
     * Get form input image
     * 
     * @param  array $column
     * @param  \App\Libraries\Scaffolding\ScaffoldingTable $Scaffolding
     * 
     * @return  string
     */
    public function getFormInputImage($column, $Scaffolding)
    {
        $Model = clone $Scaffolding->getModel();
        echo Form::file($column['name'], $column['attributes']);
        if ($Model->image) {
            ?>
            <img src="<?php echo eventsImageUrl($Model->image); ?>" width="200"/>
            <?php
        }
    }

    /**
     * Set start_date and end_date column
     * 
     * @param array $parameters
     * 
     * @return array
     */
    public function modifyRequest($parameters)
    {
        // Set start_date and end_date
        $parameters['start_date'] = ($parameters['start_date']) ? date("Y-m-d", strtotime($parameters['start_date'])) : null;
        $parameters['end_date'] = ($parameters['end_date']) ? date("Y-m-d", strtotime($parameters['end_date'])) : null;
        $parameters['start_time'] = ($parameters['start_time']) ? date("H:i:s", strtotime($parameters['start_time'])) : null;
        $parameters['end_time'] = ($parameters['end_time']) ? date("H:i:s", strtotime($parameters['end_time'])) : null;
        $Request = request();
        // Set image
        $filename = null;
        $hasImage = $Request->hasFile('image');
        if ($hasImage) {
            // Upload new file
            $destinationPath = eventsImageTemporaryPath();
            $file = $Request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $filename = getUniqueFilename() . '.' . $fileExtension;
            $fullPath = $destinationPath . $filename;
            while (file_exists($fullPath)) {
                $filename = getUniqueFilename() . '.' . $fileExtension;
                $fullPath = $destinationPath . $filename;
            }
            $status = $file->move($destinationPath, $filename); // uploading file to given path
            $Request->files->remove('image');
            $parameters['image'] = $filename;
        }
        $Model = $this->scaffolding->getModel();
        $this->image_old = $Model->image;
        return $parameters;
    }

    public function modifyValidationRulesJS($rules)
    {
        unset($rules['start_date']['date'], $rules['end_date']['date'], $rules['image']['maxlength']);
        $rules['image']['accept'] = "image/png,image/jpeg";
        return $rules;
    }

    /**
     * Modify validation
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function modifyValidation($rules)
    {
        unset($rules['start_date'], $rules['end_date']);
        $rules['image'] = 'file|mimetypes:image/png,image/jpeg|nullable';
        $rules['start_date'] = 'date_format:m/d/Y';
        $rules['end_date'] = 'date_format:m/d/Y';
        $rules['start_time'] = 'date_format:g:i A';
        $rules['end_time'] = 'date_format:g:i A';
        $rules['id_organizer'] .= '|exists:organizers,id';
        return $rules;
    }

}
