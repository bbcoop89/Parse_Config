<?php


namespace ParseConfig\Representations;


/**
 * Class ConfigurationErrorRepresentation
 * @package ParseConfig\Representations
 */
class ConfigurationErrorRepresentation extends ConfigurationResponseRepresentation
{

    /**
     * @var ConfigurationWarningRepresentation[] $warnings
     */
    private $warnings;


    /**
     * @param string $message
     * @param ConfigurationWarningRepresentation[]  $warnings
     * @return ConfigurationErrorRepresentation
     */
    public static function createError($message, array $warnings = [])
    {
        $configurationError = new self();
        $configurationError->status = 'Error';
        $configurationError->message = $message;

        if(!empty($warnings)) {
            $configurationError->warnings = $warnings;
        }

        return $configurationError;
    }

    /**
     * @return ConfigurationWarningRepresentation[]
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * @param ConfigurationWarningRepresentation[] $warnings
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return sprintf("%s!!  %s\nWarnings : %s",
            $this->status,
            $this->message,
            json_encode($this->warnings, JSON_PRETTY_PRINT)
        );
    }
}