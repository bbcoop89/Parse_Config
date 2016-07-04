<?php


namespace ParseConfig\Validators;


/**
 * Class DoubleTypeValidator
 * @package ParseConfig\Validators
 */
class DoubleTypeValidator implements TypeValidatorInterface
{

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        if(!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return false;
        }

        return true;
    }
}