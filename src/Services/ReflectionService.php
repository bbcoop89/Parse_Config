<?php

namespace ParseConfig\Services;


/**
 * Class ReflectionService
 * @package ParseConfig\Services
 */
class ReflectionService
{
    /**
     * @param mixed $returnObject
     * @param \stdClass $properties
     * @return mixed
     */
    public static function setProperties($returnObject, \stdClass $properties)
    {
        $reflectionObject = new \ReflectionObject($returnObject);

        foreach($properties as $property => $value) {
            $p = $reflectionObject->getProperty($property);
            $p->setAccessible(true);
            $p->setValue($returnObject, $value);
        }

        return $returnObject;
    }
}