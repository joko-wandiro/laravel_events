<?php

if (!function_exists('settings')) {

    /**
     * Get settings by key
     * 
     * @param string $key
     * @return string
     */
    function settings($key)
    {
        return isset($GLOBALS['settings'][$key]) ? $GLOBALS['settings'][$key] : "";
    }

}

if (!function_exists('to_number')) {

    /**
     * Change thousand format to number
     * 
     * @param string $thousand_format
     * @return int
     */
    function to_number($thousand_format = 0)
    {
        return str_replace(".", "", $thousand_format);
    }

}

if (!function_exists('getThousandFormat')) {

    /**
     * Get thousand format of number
     * 
     * @param int $number
     * 
     * @return string
     */
    function getThousandFormat($number = 0)
    {
        return number_format($number, 0, config('app.decimal_separator'), config('app.thousand_separator'));
    }

}

if (!function_exists('categoryImagePath')) {

    function categoryImagePath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('categoryImageTemporaryPath')) {

    function categoryImageTemporaryPath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'categories' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('eventsImageUrl')) {

    function eventsImageUrl($filename = null)
    {
        return asset('uploads/events/' . $filename);
    }

}

if (!function_exists('image_url_medium')) {

    function image_url_medium($filename = null)
    {
        $pathinfos = pathinfo($filename);
        $filename = $pathinfos['filename'] . '_medium.' . $pathinfos['extension'];
        return url('uploads/' . $filename);
    }

}

if (!function_exists('eventsImagePath')) {

    function eventsImagePath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('eventsImageTemporaryPath')) {

    function eventsImageTemporaryPath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('organizersImageUrl')) {

    function organizersImageUrl($filename = null)
    {
        return asset('uploads/organizers/' . $filename);
    }

}

if (!function_exists('organizersImagePath')) {

    function organizersImagePath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'organizers' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('organizersImageTemporaryPath')) {

    function organizersImageTemporaryPath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'organizers' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('imagesTemporaryPath')) {

    function imagesTemporaryPath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('imagesPath')) {

    function imagesPath($filename = null)
    {
        $path = 'uploads' . DIRECTORY_SEPARATOR;
        $path = (!$filename) ? $path : $path . $filename;
        return public_path($path);
    }

}

if (!function_exists('image_url')) {

    function image_url($filename = null)
    {
        return url('uploads/' . $filename);
    }

}

if (!function_exists('productImageUrl')) {

    function productImageUrl($filename = null)
    {
        return asset('uploads/products/' . $filename);
    }

}

if (!function_exists('getUniqueFilename')) {

    /**
     * Get unique filename
     *
     * @return string
     */
    function getUniqueFilename()
    {
        return time() . str_random(8);
    }

}
if (!function_exists('getFormInputError')) {

    /**
     * Get form input error
     *
     * @return string
     */
    function getFormInputError($column)
    {
        ob_start();
        $errors = request()->session()->get('errors');
        if ($errors) {
            $errorMessages = $errors->getMessages();
            $labelError = '<label class="error">%1$s</label>';
            // Display errors
            if (isset($errorMessages[$column])) {
                foreach ($errorMessages[$column] as $errorMessage) {
                    echo sprintf($labelError, e($errorMessage));
                }
            }
        }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}

if (!function_exists('get_date_indonesian_format')) {

    /**
     * get date indonesian format
     *
     * @return string
     */
    function get_date_indonesian_format($value)
    {
        return date('d F Y', strtotime($value));
    }

}

if (!function_exists('get_time_indonesian_format')) {

    /**
     * get time indonesian format
     *
     * @return string
     */
    function get_time_indonesian_format($value)
    {
        return date('h:i A', strtotime($value));
    }

}

// Old functions
if (!function_exists('to_url_component')) {

    /**
     * Url component
     * 
     * @param string $value
     * 
     * @return string
     */
    function to_url_component($value)
    {
        return str_replace(" ", "-", strtolower($value));
    }

}

