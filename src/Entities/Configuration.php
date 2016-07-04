<?php


namespace ParseConfig\Entities;

use ParseConfig\Helpers\ParseConfigValueHelper;


/**
 * Class Configuration
 * @package ParseConfig\Entities
 */
class Configuration implements \JsonSerializable
{
    /**
     * @var string $key
     */
    private $key;

    /**
     * @var mixed $value
     */
    private $value;

    /**
     * Configuration constructor.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key = ParseConfigValueHelper::normalizeValue($key);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{key: $this->key, value: $this->value}";

    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $configuration = new \stdClass();

        $configuration->key = $this->key;
        $configuration->value = $this->value;

        return $configuration;
    }
}