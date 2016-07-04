<?php


namespace ParseConfig\Validators;


/**
 * Class IntegerTypeValidator
 * @package ParseConfig\Validators
 */
class IntegerTypeValidator implements TypeValidatorInterface
{

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
         if(
            !@filter_var(
                $value,
                FILTER_VALIDATE_INT,
                array(
                    "options"=> array(
                        "min_range"=> PHP_INT_MIN,
                        "max_range"=> PHP_INT_MAX
                    )
                )
            )
        ) {
            return false;
        }

        return true;
    }
}