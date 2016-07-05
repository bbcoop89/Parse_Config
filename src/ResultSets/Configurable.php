<?php

namespace ParseConfig\ResultSets;


/**
 * Interface Configurable
 * @package ParseConfig\ResultSets
 */
interface Configurable
{
    /**
     * @return int
     */
    public function getConfigId();

    /**
     * @return string
     */
    public function getConfigKey();

    /**
     * @return mixed
     */
    public function getConfigValue();

    /**
     * @return int
     */
    public function getConfigFileId();

    /**
     * @return int
     */
    public function getConfigTypeId();
}