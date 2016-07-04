<?php


namespace ParseConfig\Helpers\Output;


use Zend\Console\ColorInterface;

/**
 * Class ParseConfigSuccessOutputHelper
 * @package ParseConfig\Helpers
 */
class ParseConfigSuccessOutputHelper extends ParseConfigOutputHelper
{
    /**
     * ParseConfigSuccessOutputHelper constructor.
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
            $this->status = 'SUCCESS';
        }

        $this->color = ColorInterface::WHITE;
        $this->backgroundColor = ColorInterface::CYAN;
        $this->textDecoration = "****** $this->status ******";
    }
}