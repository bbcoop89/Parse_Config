<?php


namespace ParseConfig\Helpers\Output;


use Zend\Console\ColorInterface;

/**
 * Class ParseConfigWarningOutputHelper
 * @package ParseConfig\Helpers
 */
class ParseConfigWarningOutputHelper extends ParseConfigOutputHelper
{
    /**
     * ParseConfigWarningOutputHelper constructor.
     *
     * @param mixed $message
     * @param null|string $status
     */
    public function __construct($message, $status = null)
    {
        parent::__construct($message);

        if($status !== null) {
            $this->status = $status;
        } else {
            $this->status = 'WARNING';
        }

        $this->color = ColorInterface::WHITE;
        $this->backgroundColor = ColorInterface::YELLOW;
        $this->textDecoration = "****** $this->status ******";
    }
}