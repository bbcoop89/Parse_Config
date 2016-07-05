<?php


namespace ParseConfig\Converters;

/**
 * Class DoubleConverter
 * @package ParseConfig\Converters
 */
class DoubleConverter extends AbstractConverter
{
    /**
     * DoubleConverter constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->type = 'double';

        parent::__construct($value);
    }

    /**
     * @return float
     */
    function convert()
    {
        return doubleval($this->value);
    }
}