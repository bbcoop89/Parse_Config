<?php

namespace ParseConfig\Mappers;


use ParseConfig\Entities\ConfigurationFile;
use ParseConfig\Exceptions\ResultSetNotValidException;
use ParseConfig\Exceptions\UnableToFindConfigurationFileException;
use ParseConfig\Exceptions\UnableToInsertConfigurationFileException;
use ParseConfig\Services\ReflectionService;
use ParseConfig\ResultSets\ConfigurationFileRS;
use ParseConfig\ResultSets\Fileable;
use ParseConfig\Services\QueryService;

/**
 * Class ConfigurationFileMapper
 * @package ParseConfig\Mappers
 */
class ConfigurationFileMapper
{
    /**
     * @var \PDO $pdo
     */
    private $pdo;

    /**
     * ConfigurationFileMapper constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param Fileable $fileable
     * @return ConfigurationFile
     * @throws ResultSetNotValidException
     */
    private function hydrate(Fileable $fileable)
    {
        $this->assertValidFileResult($fileable);

        $configurationFile = (new \ReflectionClass(ConfigurationFile::class))
            ->newInstanceWithoutConstructor();

        $properties = new \stdClass();
        $properties->id = $fileable->getConfigFileId();
        $properties->filePath = $fileable->getConfigFilePath();

        ReflectionService::setProperties($configurationFile, $properties);

        return $configurationFile;
    }

    /**
     * @param array $dbResults
     * @return array
     */
    private function hydrateAll(array $dbResults)
    {
        $configurationFiles = [];

        foreach($dbResults as $result)
        {
            $configurationFiles[] = $this->hydrate($result);
        }

        return $configurationFiles;
    }

    /**
     * @param $configurationFileId
     * @return ConfigurationFile|null
     * @throws UnableToFindConfigurationFileException
     */
    public function getById($configurationFileId)
    {
        try {
            $stmt = $this->pdo->prepare(QueryService::selectConfigurationFileById());
            $stmt->bindValue(':fileId', $configurationFileId);
            $stmt->execute();

            $fileResult = $stmt->fetchObject(ConfigurationFileRS::class);
        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToFindConfigurationFileException(
                sprintf("Cannot find configuration file by id # %d",
                    $configurationFileId
                )
            );
        }

        if($fileResult) {
            return $this->hydrate($fileResult);
        } else {
            return null;
        }
    }

    /**
     * @param ConfigurationFile $configurationFile
     * @return ConfigurationFile
     * @throws UnableToInsertConfigurationFileException
     */
    public function addConfigurationFile(ConfigurationFile $configurationFile)
    {
        try {
            $stmt = $this->pdo->prepare(QueryService::insertConfigurationFile());
            $stmt->bindValue(':filePath', $configurationFile->getFilePath());
            $stmt->execute();

            $properties = new \stdClass();
            $properties->id = (int)$this->pdo->lastInsertId();
        } catch(\PDOException $e) {
            error_log($e);
            throw new UnableToInsertConfigurationFileException(
                "Configuration file could not be inserted"
            );
        }

        ReflectionService::setProperties($configurationFile, $properties);

        return $configurationFile;
    }

    /**
     * @param Fileable $fileable
     * @throws ResultSetNotValidException
     */
    private function assertValidFileResult(Fileable $fileable)
    {
        if(
            !property_exists($fileable, 'config_file_id')
            || !property_exists($fileable, 'config_file_path')
        ) {
            throw new ResultSetNotValidException(
                "Result Set for Configuration File not Valid."
            );
        }
    }
}