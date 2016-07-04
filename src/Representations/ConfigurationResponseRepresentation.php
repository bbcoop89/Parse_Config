<?php


namespace ParseConfig\Representations;


/**
 * Class ConfigurationResponseRepresentation
 * @package ParseConfig\Representations
 */
abstract class ConfigurationResponseRepresentation
{
    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}