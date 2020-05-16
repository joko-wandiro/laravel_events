<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Scaffolding;
use Form;

class ProductsController extends BackEndController
{

    protected $table = 'products';

    /**
     * Get category list
     *
     * @return array
     */
    public function getCategoryList()
    {
        $Model = new \App\Models\Categories;
        $list = array("" => trans('main.select.default'));
        $result = $Model->get()->pluck("name", "id")->all();
        $list = $list + $result;
        return $list;
    }

    /**
     * Build products page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $categoryList = $this->getCategoryList();
        $Scaffolding = clone $this->scaffolding;
        $Scaffolding->join('categories', 'categories.id', '=', 'products.id_category', 'INNER');
        // Define form input filler for category
        $Scaffolding->setFormInputFiller("id_category", $categoryList);
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
                'name' => "categories.name AS category_name",
                'width' => '10%',
            ),
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
                'name' => 'price',
                'width' => '20%',
            ),
            // Add Actions custom column
            array(
                'name' => 'xaction',
                'label' => '&nbsp;',
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
    public function listBeforeTable($Scaffolding)
    {
        $parameters = array(
            'categoriesLink' => action(config('app.backend_namespace') . 'CategoriesController@index'),
            'measurementsLink' => action(config('app.backend_namespace') . 'MeasurementsController@index'),
        );
        echo view('backend.themes.sea.product_notification', $parameters)->render();
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
            echo '<img src="' . productImageUrl($model['image']) . '" width="200" />';
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
        $rules['id_category'] .= '|exists:categories,id';
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
            $destinationPath = productImageTemporaryPath();
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
            rename(productImageTemporaryPath($Model->image), productImagePath($Model->image));
            // Delete previous file
            if ($old['image']) {
                unlink(productImagePath($old['image']));
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
