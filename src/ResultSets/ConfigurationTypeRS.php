<?php

namespace ParseConfig\ResultSets;


/**
 * Class ConfigurationTypeRS
 * @package ParseConfig\ResultSets
 */
class ConfigurationTypeRS implements Typeable
{
    /**
     * @var int $config_type_id
     */
    private $config_type_id;

    /**
     * @var string $config_type_name
     */
    private $config_type_name;

    /**
     * @return string
     */
    public function getConfigTypeName()
    {
        return $this->config_type_name;
    }

    /**
     * @return int
     */
    public function getConfigTypeId()
    {
        return $this->config_type_id;
    }
}
