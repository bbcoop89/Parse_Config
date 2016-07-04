<?php


namespace ParseConfig\Validators;


/**
 * Interface TypeValidatorInterface
 * @package ParseConfig\Validators
 */
interface TypeValidatorInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value);
}