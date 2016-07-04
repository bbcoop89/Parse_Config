<?php


namespace ParseConfig\Representations;


use ParseConfig\Entities\Configuration;

/**
 * Class ConfigurationSuccessRepresentation
 * @package ParseConfig\Representations
 */
class ConfigurationSuccessRepresentation extends ConfigurationResponseRepresentation
{
    /**
     * @var Configuration $configurationFound
     */
    private $configurationFound;

    /**
     * @param string $message
     * @param Configuration $configuration
     * @return ConfigurationSuccessRepresentation
     */
    public static function createSuccess($message, Configuration $configuration)
    {
        $configurationSuccess = new self();
        $configurationSuccess->status = 'Success';
        $configurationSuccess->message = $message;
        $configurationSuccess->configurationFound = $configuration;

        return $configurationSuccess;
    }

    /**
     * @return Configuration
     */
    public function getConfigurationFound()
    {
        return $this->configurationFound;
    }

    /**
     * @param Configuration $configurationFound
     */
    public function setConfigurationFound($configurationFound)
    {
        $this->configurationFound = $configurationFound;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->status}!!  $this->message : " . json_encode($this->configurationFound);
    }
}
