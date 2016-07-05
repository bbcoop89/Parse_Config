<?php

namespace ParseConfig\Entities;


/**
 * Class ConfigurationFile
 * @package ParseConfig\Entities
 */
class ConfigurationFile implements \JsonSerializable
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $fileName
     */
    private $fileName;

    /**
     * ConfigurationFile constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
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
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
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
        $configurationFile = new \stdClass();

        $configurationFile->fileName = $this->fileName;;

        return $configurationFile;
    }
}