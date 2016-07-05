<?php

namespace ParseConfig\ResultSets;


/**
 * Class ConfigurationFileRS
 * @package ParseConfig\ResultSets
 */
class ConfigurationFileRS implements Fileable
{
    /**
     * @var int $config_file_id
     */
    private $config_file_id;

    /**
     * @var string $config_file_name
     */
    private $config_file_name;

    /**
     * @return int
     */
    public function getConfigFileId()
    {
        return $this->config_file_id;
    }

    /**
     * @return string
     */
    public function getConfigFileName()
    {
        return $this->config_file_name;
    }
}