<?php


namespace ParseConfig\Converters;

/**
 * Class AbstractConverter
 * @package ParseConfig\Converters
 */
abstract class AbstractConverter
{
    /**
     * @var string $value
     */
    protected $value;

    /**
     * AbstractConverter constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    abstract function convert();
}