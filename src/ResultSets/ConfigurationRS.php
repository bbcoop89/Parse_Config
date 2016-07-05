<?php

namespace ParseConfig\ResultSets;


/**
 * Class ConfigurationRS
 * @package ParseConfig\ResultSets
 */
class ConfigurationRS implements Configurable
{
    /**
     * @var int $config_id
     */
    private $config_id;

    /**
     * @var string $config_key
     */
    private $config_key;

    /**
     * @var mixed $config_value
     */
    private $config_value;

    /**
     * @var int $config_type_id
     */
    private $config_type_id;

    /**
     * @var int $config_file_id
     */
    private $config_file_id;

    /**
     * @return int
     */
    public function getConfigId()
    {
        return $this->config_id;
    }

    /**
     * @return string
     */
    public function getConfigKey()
    {
        return $this->config_key;
    }

    /**
     * @return mixed
     */
    public function getConfigValue()
    {
        return $this->config_value;
    }

    /**
     * @return int
     */
    public function getConfigTypeId()
    {
        return $this->config_type_id;
    }

    /**
     * @return int
     */
    public function getConfigFileId()
    {
        return $this->config_file_id;
    }
}