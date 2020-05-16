<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;

class OrganizersController extends BackEndController
{

    protected $table = 'organizers';

    /**
     * Build products page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $Scaffolding = clone $this->scaffolding;
        // Upload file to temporary folder and set it into parameters
        $Scaffolding->addHooks("insertModifyRequest", array($this, "setImage"));
        $Scaffolding->addHooks("updateModifyRequest", array($this, "setImage"));
        // Upload file to permanent folder
        $Scaffolding->addHooks("insertAfterInsert", array($this, "moveImage"));
        $Scaffolding->addHooks("updateAfterUpdate", array($this, "moveImage"));
        // Modify image form input
        $Scaffolding->setFormInput('image', array($this, 'getFormInputImage'));
        // Modify validation rules
        $Scaffolding->addHooks("insertModifyValidationRules", array($this, "modifyValidation"));
        $Scaffolding->addHooks("updateModifyValidationRules", array($this, "modifyValidation"));
        $Scaffolding->addHooks("modifyValidationRulesJS", array($this, "modifyValidationRulesJS"));
        // Set formatter for image column
        $Scaffolding->addFormatterColumn('image', array($this, 'formatterImage'));
        // Set columns properties
        $parameters = array(
            array(
                'name' => 'image',
                'width' => '20%',
                'order' => FALSE,
                'search' => FALSE,
            ),
            array(
                'name' => 'name',
                'width' => '30%',
            ),
            array(
                'name' => 'description',
                'width' => '20%',
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
        // Hooks Action for delete operation ( AJAX Request )
        $Scaffolding->addHooks("deleteModifyResponse", array($this, "deleteModifyResponse"));
        $content = $Scaffolding->render();
        $parameters = array(
            'scaffolding' => $content,
        );
        return $this->render($parameters);
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
            echo '<img src="' . organizersImageUrl($model['image']) . '" width="200" />';
        } else {
            echo '-';
        }
    }

    /**
     * Modify validation
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function modifyValidation($rules)
    {
        $rules['image'] = 'file|mimetypes:image/png,image/jpeg|nullable';
        return $rules;
    }

    /**
     * Modify javascript validation rules
     * 
     * @param  array $rules
     * 
     * @return  array
     */
    public function modifyValidationRulesJS($rules)
    {
        unset($rules['image']['maxlength']);
        $rules['image']['accept'] = "image/png,image/jpeg";
        return $rules;
    }

    /**
     * Set image column
     * 
     * @param array $parameters
     * 
     * @return array
     */
    public function setImage($parameters)
    {
        $Request = request();
        // Upload photo file
        $filename = null;
        $hasImage = $Request->hasFile('image');
        if ($hasImage) {
            // Upload new file
            $destinationPath = organizersImageTemporaryPath();
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
        return $parameters;
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
        $old = unserialize($Request['idx_old']);
        $filename = null;
        $hasImage = $Request->hasFile('image');
        if ($hasImage) {
            // Move image file to permanent directory
            rename(organizersImageTemporaryPath($Model->image), organizersImagePath($Model->image));
            // Delete previous file
            if ($old['image']) {
                unlink(organizersImagePath($old['image']));
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
        echo Form::file($column['name'], $column['attributes']);
    }

}
