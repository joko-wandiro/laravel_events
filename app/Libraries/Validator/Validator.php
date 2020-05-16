<?php

namespace App\Libraries\Validator;

use Closure;
use DateTime;
use Countable;
use Exception;
use DateTimeZone;
use RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use BadMethodCallException;
use InvalidArgumentException;
use Illuminate\Support\Fluent;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Validation\Validator as OldValidator;
use DB;
use App\Models\Products;

class Validator extends OldValidator
{
    /**
     * Get id and product_id values
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    protected function exitGoodsDetail($attribute)
    {
    	$attributes= explode(".", $attribute);
    	$id= $this->getValue('exit_goods_detail.' . $attributes[1] . '.id');
    	$id= ($id) ? $id : null;
    	$productId= $this->getValue('exit_goods_detail.' . $attributes[1] . '.product_id');
    	return array('id'=>$id, 'productId'=>$productId);
    }
    
    /**
     * Validate stock
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  array   $parameters
     * @return bool
     */
    protected function validateStock($attribute, $value, $parameters)
    {
        $method             = isset($parameters[0]) ? $parameters[0] : null;
        if ($method) {
            $values= $this->$method($attribute);
        }
        // Get stock of specific product
        $Model          = new Products;
        $record = $Model->getStock($values['productId'], $values['id']);
        return $record['stock'] >= $value;
    }
}