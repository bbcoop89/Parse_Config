<?php


namespace ParseConfig\Converters;

/**
 * Class IntegerConverter
 * @package ParseConfig\Converters
 */
class IntegerConverter extends AbstractConverter
{
    /**
     * IntegerConverter constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->type = 'integer';

        parent::__construct($value);
    }

    /**
     * @return int
     */
    function convert()
    {
        return intval($this->value);
    }
}