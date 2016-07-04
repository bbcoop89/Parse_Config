<?php


namespace ParseConfig\Services;


use ParseConfig\Exceptions\UnableToOpenConfigurationException;

/**
 * Class FileService
 * @package ParseConfig\Services
 */
class FileService
{

    /**
     * @var string $configurationFileName
     */
    private $configurationFileName;

    /**
     * FileService constructor.
     *
     * @param string $configurationFileName
     */
    public function __construct($configurationFileName)
    {
        $this->configurationFileName = $configurationFileName;
    }

    /**
     * @return string
     */
    public function getConfigurationFileName()
    {
        return $this->configurationFileName;
    }

    /**
     * @param string $configurationFileName
     */
    public function setConfigurationFileName($configurationFileName)
    {
        $this->configurationFileName = $configurationFileName;
    }

    /**
     * @param string $mode
     * @return resource
     * @throws UnableToOpenConfigurationException
     */
    public function openFile($mode = 'r')
    {
        try {
            $fileHandle = @fopen($this->configurationFileName, $mode);
        } catch (\Exception $e) {
            throw new UnableToOpenConfigurationException(
                sprintf("Unable to open configuration file with name [%s] and mode [%s]",
                    $this->configurationFileName,
                    $mode
                )
            );
        }

        return $fileHandle;
    }

    /**
     * @param resource $fileHandle
     */
    public function closeFile($fileHandle)
    {
        @fclose($fileHandle);
    }
}