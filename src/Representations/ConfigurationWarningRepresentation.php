<?php


namespace ParseConfig\Representations;


/**
 * Class ConfigurationErrorService
 * @package ParseConfig\Representations
 */
class ConfigurationWarningRepresentation extends ConfigurationResponseRepresentation
{
    /**
     * @var int $lineNumber
     */
    private $lineNumber;

    /**
     * @var string $rawData
     */
    private $rawData;


    /**
     * @param int $lineNumber
     * @param string $rawData
     * @param string $message
     * @return ConfigurationWarningRepresentation
     */
    public static function createWarningResponse($lineNumber, $rawData, $message)
    {
        $configurationWarning = new self();
        $configurationWarning->status = 'Warning';
        $configurationWarning->lineNumber = $lineNumber;
        $configurationWarning->rawData = $rawData;
        $configurationWarning->message = $message;

        return $configurationWarning;
    }

    /**
     * @return int
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @param int $lineNumber
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;
    }

    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param string $rawData
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s!! With message : '%s', Line Number : %d, Data : '%s'",
            $this->status,
            $this->message,
            $this->lineNumber,
            trim(preg_replace('/\s\s+/', ' ', $this->rawData))
        );
    }
}