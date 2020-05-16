<?php

namespace App\Libraries\Validator;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Translation\TranslatorInterface;
use Illuminate\Contracts\Validation\Factory as FactoryContract;
use Illuminate\Validation\Factory as IlluminateValidationFactory;

class Factory extends IlluminateValidationFactory
{
    /**
     * Resolve a new Validator instance.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Validation\Validator
     */
    protected function resolve(array $data, array $rules, array $messages, array $customAttributes)
    {
        if (is_null($this->resolver)) {
            return new Validator($this->translator, $data, $rules, $messages, $customAttributes);
        }

        return call_user_func($this->resolver, $this->translator, $data, $rules, $messages, $customAttributes);
    }
}
