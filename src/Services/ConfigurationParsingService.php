<?php


namespace ParseConfig\Services;

use ParseConfig\Converters\AbstractConverter;
use ParseConfig\Entities\Configuration;
use ParseConfig\Exceptions\ConfigurationFileReadingException;
use ParseConfig\Exceptions\UnableToCreateConfigurationException;
use ParseConfig\Exceptions\UnableToOpenConfigurationException;
use ParseConfig\Factories\ConfigurationValueConverterFactory;
use ParseConfig\Helpers\Output\ParseConfigErrorOutputHelper;
use ParseConfig\Helpers\Output\ParseConfigOutputHelper;
use ParseConfig\Helpers\Output\ParseConfigSuccessOutputHelper;
use ParseConfig\Helpers\Output\ParseConfigWarningOutputHelper;
use ParseConfig\Mappers\ConfigurationMapper;
use ParseConfig\Representations\ConfigurationErrorRepresentation;
use ParseConfig\Representations\ConfigurationWarningRepresentation;
use ParseConfig\Representations\ConfigurationSuccessRepresentation;
use ParseConfig\Representations\ParseStatusRepresentation;
use ParseConfig\Settings\DatabaseSettings;


/**
 * Class ConfigurationFileParsingService
 * @package ParseConfig\Services
 */
class ConfigurationParsingService
{
    /**
     * @var FileService $fileService
     */
    private $fileService;

    /**
     * @var AbstractConverter $configurationValueConverter
     */
    private $configurationValueConverter;

    /**
     * @var ParseConfigOutputHelper $outputHelper
     */
    private $outputHelper;

    /**
     * ConfigurationParsingService constructor.
     *
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @return FileService
     */
    public function getFileService()
    {
        return $this->fileService;
    }

    /**
     * @param FileService $fileService
     */
    public function setFileService($fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @return AbstractConverter
     */
    public function getConfigurationValueConverter()
    {
        return $this->configurationValueConverter;
    }

    /**
     * @param AbstractConverter $configurationValueConverter
     */
    public function setConfigurationValueConverter($configurationValueConverter)
    {
        $this->configurationValueConverter = $configurationValueConverter;
    }

    /**
     * @return ParseConfigOutputHelper
     */
    public function getOutputHelper()
    {
        return $this->outputHelper;
    }

    /**
     * @param ParseConfigOutputHelper $outputHelper
     */
    public function setOutputHelper($outputHelper)
    {
        $this->outputHelper = $outputHelper;
    }

    /**
     * @throws ConfigurationFileReadingException
     */
    public function getConfigurationSettings()
    {
        $this->parseConfiguration();
    }

    /**
     * @param string $status
     * @param null|string $message
     */
    private function notifyStatus($status, $message = null)
    {
        switch(true) {
            case $this->isStarting($status):
                $this->outputHelper = new ParseConfigOutputHelper(
                    ParseConfigOutputHelper::START_LINE
                );
                break;
            case $this->isEnding($status):
                $this->outputHelper = new ParseConfigOutputHelper(
                    ParseConfigOutputHelper::END_LINE
                );
                break;
            default:
                $this->outputHelper = new ParseConfigOutputHelper(
                    $message, $status
                );
        }

        $this->outputHelper->write();
    }

    /**
     * @param string $status
     * @return bool
     */
    private function isStarting($status)
    {
        return $status === ParseStatusRepresentation::START_STATUS_CODE
            || $status === ParseStatusRepresentation::START_STATUS;
    }

    /**
     * @param string $status
     * @return bool
     */
    private function isEnding($status)
    {
        return $status === ParseStatusRepresentation::ENDING_STATUS
            || $status === ParseStatusRepresentation::ENDING_STATUS_CODE;
    }

    /**
     * @param int $lineCounter
     * @param string $data
     * @return string
     */
    private function notifyWarning($lineCounter, $data)
    {
        $warning = ConfigurationWarningRepresentation::createWarningResponse(
            $lineCounter,
            $data,
            'Invalid Data Format'
        )->__toString();

        $this->outputHelper = new ParseConfigWarningOutputHelper($warning);

        $this->outputHelper->write();

        return $warning;
    }

    /**
     * @param Configuration $configuration
     * @return string
     */
    private function notifySuccess(Configuration $configuration)
    {
        $success = ConfigurationSuccessRepresentation::createSuccess('Configuration Line Parsed Successfully', $configuration)->__toString();

        $this->outputHelper = new ParseConfigSuccessOutputHelper($success);

        $this->outputHelper->write();

        return $success;
    }


    /**
     * @param array $invalidResponses
     * @return string
     */
    private function notifyError(array $invalidResponses = [])
    {
        $error = ConfigurationErrorRepresentation::createError(
            'Configurations could not be saved due to invalid data.  Please fix these and try again.',
            $invalidResponses
        )->__toString();

        $this->outputHelper = new ParseConfigErrorOutputHelper($error);

        $this->outputHelper->write();

        return $error;
    }


    /**
     * @throws ConfigurationFileReadingException
     * @throws UnableToCreateConfigurationException
     * @throws UnableToOpenConfigurationException
     */
    private function parseConfiguration()
    {
        $data = null;
        $configurations = [];
        $invalidResponses = [];
        $configuration = null;


        $lineCounter = 1;

        $fileHandle = $this->fileService->openFile();

        $this->notifyStatus(ParseStatusRepresentation::START_STATUS);

            try {
                while(!feof($fileHandle)) {
                    $data = $this->getConfigLine($fileHandle);

                    $dataPieces = explode('=', $data);

                    if (empty($dataPieces) || $this->configLineIsUndefined($dataPieces)) {

                        if(strpos($data, '#') === 0 || $this->configLineIsBlank($data)) {
                            continue;
                        }

                        $warning =  $this->notifyWarning($lineCounter, $data);

                        $invalidResponses[] = $warning;

                    } else {
                        $trueValue = $this->convertValueToTrueValue($dataPieces[1]);

                        $configuration = new Configuration($dataPieces[0], $trueValue, $this->configurationValueConverter->getType());

                        $this->notifySuccess($configuration);

                        $configurations[] = $configuration;
                    }

                    $lineCounter++;
                }

            } catch(\Exception $e) {
                throw new ConfigurationFileReadingException(
                    'An error occurred reading configuration file'
                );
            } finally {
                $this->fileService->closeFile($fileHandle);
            }

        if(!empty($invalidResponses)) {
            $this->notifyError($invalidResponses);
        } else {
            $configurationMapper = new ConfigurationMapper(DatabaseSettings::getMySqlPdo());
            $success = $configurationMapper->saveAllConfigurations($configurations, $this->fileService->getConfigurationFileName());

            if($success) {
                $this->notifyStatus('ENTITIES CREATED', 'CONFIGURATIONS SAVED');
            } else {
                throw new UnableToCreateConfigurationException(
                    "Configurations could not be inserted into the database"
                );
            }

        }

        $this->notifyStatus(ParseStatusRepresentation::ENDING_STATUS);
    }

    /**
     * @param string $value
     * @return mixed
     */
    private function convertValueToTrueValue($value)
    {
        $this->setConfigurationValueConverter(ConfigurationValueConverterFactory::getConfigurationValueConverter($value));
        return $this->configurationValueConverter->convert();
    }

    /**
     * @param resource $fileHandle
     * @return string
     */
    private function getConfigLine($fileHandle)
    {
        return fgets($fileHandle);
    }

    /**
     * @param array $data
     * @return bool
     */
    private function configLineIsUndefined(array $data)
    {
        return count($data) < 2;
    }

    /**
     * @param string $data
     * @return bool
     */
    private function configLineIsBlank($data)
    {
        return $data === "\n" || trim($data) === '';
    }
}