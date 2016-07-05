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
     * @var string $type
     */
    protected $type;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    abstract function convert();
}