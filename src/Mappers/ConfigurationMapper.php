<?php


namespace ParseConfig\Mappers;



use ParseConfig\Entities\Configuration;
use ParseConfig\Entities\ConfigurationFile;
use ParseConfig\Entities\ConfigurationType;
use ParseConfig\Exceptions\ResultSetNotValidException;
use ParseConfig\Exceptions\UnableToCreateConfigurationException;
use ParseConfig\Exceptions\UnableToFindConfigurationException;
use ParseConfig\Exceptions\UnableToFindConfigurationFileException;
use ParseConfig\Exceptions\UnableToFindConfigurationTypeException;
use ParseConfig\Factories\ConfigurationValueConverterFactory;
use ParseConfig\Services\ReflectionService;
use ParseConfig\ResultSets\Configurable;
use ParseConfig\ResultSets\ConfigurationRS;
use ParseConfig\Services\QueryService;

/**
 * Class ConfigurationMapper
 * @package ParseConfig\Mappers
 */
class ConfigurationMapper
{
    /**
     * @var \PDO $pdo
     */
    private $pdo;

    /**
     * @var ConfigurationTypeMapper $configurationTypeMapper
     */
    private $configurationTypeMapper;

    /**
     * @var ConfigurationFileMapper $configurationFileMapper
     */
    private $configurationFileMapper;

    /**
     * ConfigurationMapper constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->configurationTypeMapper = new ConfigurationTypeMapper($pdo);
        $this->configurationFileMapper = new ConfigurationFileMapper($pdo);
    }

    /**
     * @param Configuration[] $configurations
     * @param string $configFileName
     * @return bool
     * @throws UnableToCreateConfigurationException
     */
    public function saveAllConfigurations(array $configurations, $configFileName)
    {
        try {
            $this->pdo->beginTransaction();

            $configurationFile = $this->configurationFileMapper->addConfigurationFile(new ConfigurationFile($configFileName));

            foreach($configurations as $configuration) {
                $configurationType = $this->configurationTypeMapper->getByName($configuration->getType());
                $this->addConfiguration($configuration, $configurationFile, $configurationType);

            }

            $success = $this->pdo->commit();
        } catch(\Exception $e) {
            $this->pdo->rollBack();
            error_log($e);
            throw new UnableToCreateConfigurationException(
                "Cannot insert configurations:[" . implode(',', $configurations) . "]"
            );
        }

        return $success;

    }


    /**
     * @param string $key
     * @return array
     * @throws UnableToFindConfigurationException
     */
    public function getByKey($key)
    {
        try {
            $stmt = $this->pdo->prepare(QueryService::selectConfigurationByKey());
            $stmt->bindValue(':key', $key);
            $stmt->execute();

            $configurationResult = $stmt->fetchAll(\PDO::FETCH_CLASS, ConfigurationRS::class);
        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToFindConfigurationException(
                sprintf("Configuration with key ['%s'] cannot be found.", $key)
            );
        }

        if($configurationResult) {
            return $this->hydrateAll($configurationResult);
        } else {
            return [];
        }
    }

    /**
     * @param Configurable $configurable
     * @return null|ConfigurationType
     * @throws UnableToFindConfigurationTypeException
     */
    private function getTypeForConfiguration(Configurable $configurable)
    {
        return $this->configurationTypeMapper->getById($configurable->getConfigTypeId());
    }

    /**
     * @param Configurable $configurable
     * @return ConfigurationFile|null
     * @throws UnableToFindConfigurationFileException
     */
    private function getFileForConfiguration(Configurable $configurable)
    {
        return $this->configurationFileMapper->getById($configurable->getConfigFileId());
    }

    /**
     * @param array $dbResults
     *
     * @return array
     */
    private function hydrateAll(array $dbResults) {
        $configurations = [];

        foreach($dbResults as $dbResult) {
            $configurations[] = $this->hydrate($dbResult);
        }

        return $configurations;
    }

    /**
     * @param Configurable $configurable
     * @return Configuration
     * @throws ResultSetNotValidException
     */
    private function hydrate(Configurable $configurable)
    {
        $this->assertValidConfigurationResult($configurable);

        $configuration = (new \ReflectionClass(Configuration::class))
            ->newInstanceWithoutConstructor();

        $properties = new \stdClass();

        $properties->id = $configurable->getConfigId();
        $properties->key = $configurable->getConfigKey();
        $properties->value = ConfigurationValueConverterFactory::getConfigurationValueConverter($configurable->getConfigValue())->convert();
        $properties->type = $this->getTypeForConfiguration($configurable);
        $properties->file = $this->getFileForConfiguration($configurable);

        ReflectionService::setProperties($configuration, $properties);

        return $configuration;
    }
    /**
     * @param Configuration $configuration
     * @param ConfigurationFile $configurationFile
     * @param ConfigurationType $configurationType
     * @throws UnableToCreateConfigurationException
     * @return Configuration
     */
    public function addConfiguration(Configuration $configuration, ConfigurationFile $configurationFile, ConfigurationType $configurationType)
    {
        try{
            $stmt = $this->pdo->prepare(QueryService::insertConfiguration());

            if(!$configuration->getValue() && $configurationType->isBoolean()) {
                $value = 'false';
            } else if($configuration->getValue() && $configurationType->isBoolean()){
                $value = 'true';
            } else {
                $value = $configuration->getValue();
            }

            $stmt->bindValue(':configKey', $configuration->getKey());
            $stmt->bindValue(':configValue', $value);
            $stmt->bindValue(':fileId', $configurationFile->getId());
            $stmt->bindValue(':typeId', $configurationType->getId());
            $stmt->execute();
        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToCreateConfigurationException(
                'Unable to create Configuration with key: '
                . $configuration->getKey() . ', value: '
                . ConfigurationValueConverterFactory::getConfigurationValueConverter($configuration->getValue())->convert()
            );
        }

        $properties = new \stdClass();
        $properties->id = (int)$this->pdo->lastInsertId();
        $properties->file = $configurationFile;

        $configuration = ReflectionService::setProperties($configuration, $properties);

        return $configuration;
    }

    /**
     * @param Configurable $configurable
     * @throws ResultSetNotValidException
     */
    private function assertValidConfigurationResult(Configurable $configurable)
    {
        if(
            !property_exists($configurable, 'config_id')
            || !property_exists($configurable, 'config_key')
            || !property_exists($configurable, 'config_value')
            || !property_exists($configurable, 'config_file_id')
            || !property_exists($configurable, 'config_type_id')
        ) {
            throw new ResultSetNotValidException(
                "Configuration Result Set has Invalid Properties"
            );
        }
    }
}