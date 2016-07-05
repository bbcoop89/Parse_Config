<?php

namespace ParseConfig\Mappers;


use ParseConfig\Entities\ConfigurationType;
use ParseConfig\Exceptions\ResultSetNotValidException;
use ParseConfig\Exceptions\UnableToFindConfigurationTypeException;
use ParseConfig\Services\ReflectionService;
use ParseConfig\ResultSets\ConfigurationTypeRS;
use ParseConfig\ResultSets\Typeable;
use ParseConfig\Services\QueryService;

/**
 * Class ConfigurationTypeMapper
 * @package ParseConfig\Mappers
 */
class ConfigurationTypeMapper
{
    /**
     * @var \PDO $pdo
     */
    private $pdo;

    /**
     * ConfigurationTypeMapper constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param Typeable $dbResult
     * @return ConfigurationType
     * @throws ResultSetNotValidException
     */
    private function hydrate(Typeable $dbResult)
    {
        $this->assertValidTypeResult($dbResult);

        $configurationType = (new \ReflectionClass(ConfigurationType::class))
            ->newInstanceWithoutConstructor();

        $properties = new \stdClass();
        $properties->id = $dbResult->getConfigTypeId();
        $properties->name = $dbResult->getConfigTypeName();

        ReflectionService::setProperties($configurationType, $properties);

        return $configurationType;
    }

    /**
     * @param array $dbResults
     * @return array
     */
    private function hydrateAll(array $dbResults)
    {
        $types = [];

        foreach($dbResults as $result) {
            $types[] = $this->hydrate($result);
        }

        return $types;
    }
    /**
     * @param $configurationTypeId
     * @return null|ConfigurationType
     * @throws UnableToFindConfigurationTypeException
     */
    public function getById($configurationTypeId)
    {
        try {
            $stmt = $this->pdo->prepare(QueryService::selectConfigurationTypeById());
            $stmt->bindValue(':typeId', $configurationTypeId);
            $stmt->execute();

            $typeResult = $stmt->fetchObject(ConfigurationTypeRS::class);

        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToFindConfigurationTypeException(
                sprintf('Cannot find configuration type by id # %d',
                    $configurationTypeId
                )
            );
        }

        if($typeResult) {
            return $this->hydrate($typeResult);
        } else {
            return null;
        }
    }

    /**
     * @param ConfigurationType $configurationType
     * @return ConfigurationType
     * @throws UnableToFindConfigurationTypeException
     */
    public function getByName(ConfigurationType $configurationType)
    {
        try {
            $stmt = $this->pdo->prepare(QueryService::selectConfigurationType());
            $stmt->bindValue(':typeName', $configurationType->getName());
            $stmt->execute();
        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToFindConfigurationTypeException(
                sprintf(
                    "Configuration type cannot be found by name ['%s']",
                    $configurationType->getName()
                )
            );
        }

        $properties = new \stdClass();
        $properties->id = (int)$stmt->fetchColumn();

        $configurationType = ReflectionService::setProperties($configurationType, $properties);

        return $configurationType;
    }

    /**
     * @param Typeable $configurationType
     * @throws ResultSetNotValidException
     */
    private function assertValidTypeResult(Typeable $configurationType)
    {
        if(
            !property_exists($configurationType, 'config_type_id')
            || !property_exists($configurationType, 'config_type_name')
        ) {
            throw new ResultSetNotValidException(
                "Result Set for Configuration Type is not Valid"
            );
        }
    }
}
