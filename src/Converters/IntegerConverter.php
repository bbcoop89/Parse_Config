<?php


namespace ParseConfig\Converters;

/**
 * Class IntegerConverter
 * @package ParseConfig\Converters
 */
class IntegerConverter extends AbstractConverter
{
    /**
     * @return int
     */
    function convert()
    {
        return intval($this->value);
    }
}