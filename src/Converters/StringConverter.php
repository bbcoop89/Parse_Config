<?php


namespace ParseConfig\Converters;

/**
 * Class StringConverter
 * @package ParseConfig\Converters
 */
class StringConverter extends AbstractConverter
{
    /**
     * @return string
     */
    function convert()
    {
        return strval($this->value);
    }
}