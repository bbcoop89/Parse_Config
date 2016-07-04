<?php


namespace ParseConfig\Converters;

/**
 * Class BooleanConverter
 * @package ParseConfig\Converters
 */
class BooleanConverter extends AbstractConverter
{
    /**
     * @return boolean
     */
    function convert()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN, array("flags" => FILTER_NULL_ON_FAILURE));
    }
}