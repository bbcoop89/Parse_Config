<?php

namespace ParseConfig\Helpers\Output;


use Zend\Console\ColorInterface;

/**
 * Class ParseConfigErrorOutputHelper
 * @package ParseConfig\Helpers
 */
class ParseConfigErrorOutputHelper extends ParseConfigOutputHelper
{
    /**
     * ParseConfigErrorOutputHelper constructor.
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
            $this->status = 'ERROR';
        }

        $this->color = ColorInterface::LIGHT_RED;
        $this->backgroundColor = ColorInterface::BLACK;
        $this->textDecoration = "****** $this->status ******";
    }
}