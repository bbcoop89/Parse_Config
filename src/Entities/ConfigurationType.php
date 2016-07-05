<?php

namespace ParseConfig\Entities;


/**
 * Class ConfigurationType
 * @package ParseConfig\Entities
 */
class ConfigurationType implements \JsonSerializable
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * ConfigurationType constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "name: $this->name";
    }

    /**
     * @return bool
     */
    public function isBoolean()
    {
        return $this->name === 'boolean';
    }

    /**
     * @return bool
     */
    public function isInteger()
    {
        return $this->name === 'integer';
    }

    /**
     * @return bool
     */
    public function isDouble()
    {
        return $this->name === 'double';
    }

    /**
     * @return bool
     */
    public function isString()
    {
        return $this->name === 'string';
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
        $configurationType = new \stdClass();

        $configurationType->name = $this->name;

        return $configurationType;
    }
}