<?php


namespace ParseConfig\Validators;


/**
 * Class BooleanTypeValidator
 * @package ParseConfig\Validators
 */
class BooleanTypeValidator implements TypeValidatorInterface
{

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        if(filter_var($value, FILTER_VALIDATE_BOOLEAN, array("flags" => FILTER_NULL_ON_FAILURE)) === null) {
            return false;
        }

        return true;
    }
}