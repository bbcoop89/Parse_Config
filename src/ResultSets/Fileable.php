<?php

namespace ParseConfig\ResultSets;


/**
 * Interface Fileable
 * @package ParseConfig\ResultSets
 */
interface Fileable
{
    /**
     * @return int
     */
    public function getConfigFileId();

    /**
     * @return string
     */
    public function getConfigFilePath();
}