<?php

namespace App\Libraries\Validator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Validation\Factory
 */
class ValidatorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'validator';
    }
}
