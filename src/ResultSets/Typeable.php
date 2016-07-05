<?php

namespace ParseConfig\ResultSets;


/**
 * Interface Typeable
 * @package ParseConfig\ResultSets
 */
interface Typeable
{
    /**
     * @return int
     */
    public function getConfigTypeId();

    /**
     * @return string
     */
    public function getConfigTypeName();
}