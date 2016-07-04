<?php


namespace ParseConfig\Converters;

/**
 * Class DoubleConverter
 * @package ParseConfig\Converters
 */
class DoubleConverter extends AbstractConverter
{
    /**
     * @return float
     */
    function convert()
    {
        return doubleval($this->value);
    }
}