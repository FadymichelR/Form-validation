<?php


namespace Fad\Form\Validator;

/**
 * Class ChoiceValidator
 * @package Fad\Form\Validator
 */
class EmailValidator extends Validator
{


    /**
     * @param $value
     * @return bool
     *
     */
    public function isValid($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    
}