<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Scaffolding;
use Form;
use DB;
use Validator;
use App\Models\Settings;

class SettingsController extends BackEndController
{

    protected $table = 'settings';
    protected $masterView = 'backend.themes.vish.settings';

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->js = array();
        $this->css = array();
        // Add css files
        $this->addCSS('font.awesome', 'css/font-awesome.min.css');
        $this->addCSS('jquery.ui', 'css/jquery-ui.css');
        $this->addCSS('bootstrap', 'css/bootstrap.min.css');
        $this->addCSS('dkscaffolding', 'css/vishscaffolding.css');
        $this->addCSS('ie10', 'css/ie10-viewport-bug-workaround.css');
        $this->addCSS('themes', 'css/themes/vish/theme.css');
        $this->addCSS('responsive', 'css/themes/vish/responsive.css');
        $this->addJS('jquery', 'js/jquery.min.js');
        $this->addJS('jquery.ui', 'js/jquery-ui.min.js');
        $this->addJS('jquery.blockUI', 'js/jquery.blockUI.js');
        $this->addJS('bootstrap', 'js/bootstrap.min.js');
        $this->addJS('jquery.validate', 'js/jquery.validate.min.js');
        $this->addJS('ie10', 'js/ie10-viewport-bug-workaround.js');
        $this->addJS('zerobox', 'js/zerobox.js');
        $this->addJS('zerovalidation', 'js/zerovalidation.js');
        $this->addJS('zeromask', 'js/zeromask.js');
    }

    public function edit()
    {
        $settings = Settings::get();
        $parameters = array(
            'settings' => $settings,
        );
        return $this->render($parameters);
    }

    public function update()
    {
        $Request = request();
        $request = $Request->all();
        // Validation
        $validation_rules = array(
            'name' => 'required',
            'logo' => 'file|mimetypes:image/png,image/jpeg|nullable',
            'address' => 'required',
            'phone' => 'required|numeric',
        );
        $validator = Validator::make($request, $validation_rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Update settings
        unset($request['_method'], $request['_token'], $request['submit']);
        // Upload logo
        $filename = null;
        $hasImage = $Request->hasFile('logo');
        if ($hasImage) {
            $destinationPath = imagesTemporaryPath();
            $file = $Request->file('logo');
            $fileExtension = $file->getClientOriginalExtension();
            $filename = getUniqueFilename() . '.' . $fileExtension;
            $fullPath = $destinationPath . $filename;
            while (file_exists($fullPath)) {
                $filename = getUniqueFilename() . '.' . $fileExtension;
                $fullPath = $destinationPath . $filename;
            }
            $status = $file->move($destinationPath, $filename); // uploading file to given path
            $Request->files->remove('logo');
            $request['logo'] = $filename;
        }
        $result = DB::transaction(function ($db) use ($request) {
                    foreach ($request as $key => $value) {
                        if ($key == "logo" && !$value) {
                            continue;
                        }
                        $parameters = array(
                            'value' => $value,
                        );
                        // Insert order
                        $SettingsModel = new Settings;
                        $setting = $SettingsModel->where('name', '=', $key)->update($parameters);
                    }
                    // Move logo
                    $hasImage = request()->hasFile('logo');
                    if ($hasImage) {
                        // Move image file to permanent directory
                        rename(imagesTemporaryPath($request['logo']), imagesPath($request['logo']));
                        // Delete previous file
                        if ($request['logo_old']) {
                            unlink(imagesPath($request['logo_old']));
                        }
                    }
                });
        return back()->with('dk_settings_info_success', trans('dkscaffolding.notification.update.success'));
    }

}
