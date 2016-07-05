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
     * @var int $id
     */
    private $id;

    /**
     * @var string $key
     */
    private $key;

    /**
     * @var mixed $value
     */
    private $value;

    /**
     * @var ConfigurationType $type
     */
    private $type;

    /**
     * @var ConfigurationFile $file
     */
    private $file;

    /**
     * Configuration constructor.
     *
     * @param string $key
     * @param mixed $value
     * @param string $typeName
     */
    public function __construct($key, $value, $typeName)
    {
        $this->key = ParseConfigValueHelper::normalizeValue($key);
        $this->value = $value;
        $this->type = new ConfigurationType($typeName);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ConfigurationType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ConfigurationType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return ConfigurationFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param ConfigurationFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{key: $this->key, value: $this->value, type:" . json_encode($this->type) . '}';

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
        $configuration->type = $this->type;

        return $configuration;
    }
}