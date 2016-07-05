<?php


namespace ParseConfig\Converters;

/**
 * Class BooleanConverter
 * @package ParseConfig\Converters
 */
class BooleanConverter extends AbstractConverter
{
    /**
     * BooleanConverter constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->type = 'boolean';

        parent::__construct($value);
    }

    /**
     * @return boolean
     */
    function convert()
    {
        return filter_var($this->value, FILTER_VALIDATE_BOOLEAN, array("flags" => FILTER_NULL_ON_FAILURE));
    }
}