<?php


namespace ParseConfig\Converters;

/**
 * Class StringConverter
 * @package ParseConfig\Converters
 */
class StringConverter extends AbstractConverter
{
    /**
     * StringConverter constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->type = 'string';

        parent::__construct($value);
    }

    /**
     * @return string
     */
    function convert()
    {
        return strval($this->value);
    }
}