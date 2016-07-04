<?php


namespace ParseConfig\Helpers\Output;

use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use Zend\Console\Console;


/**
 * Class ParseConfigOutputHelper
 * @package ParseConfig\Helpers
 */
class ParseConfigOutputHelper
{
    /**
     * @var string|null $status
     */
    protected $status;

    /**
     * @var string $outputLine
     */
    protected $outputLine;

    /**
     * @var mixed $message
     */
    protected $message;

    /**
     * @var int $color
     */
    protected $color;

    /**
     * @var int $backgroundColor
     */
    protected $backgroundColor;

    /**
     * @var string $textDecoration
     */
    protected $textDecoration;

    /**
     * @var AdapterInterface $console
     */
    protected $console;

    const START_LINE = 'STARTING PARSE OPERATION ......';

    const END_LINE = '...... ENDING PARSE OPERATION';

    /**
     * ParseConfigOutputHelper constructor.
     *
     * @param mixed $message
     * @param null|string $status
     */
    public function __construct($message, $status = null)
    {
        $this->message = $message;

        if($this->status !== null) {
            $this->status = $status;
        }

        $this->console = Console::getInstance();
        $this->backgroundColor = ColorInterface::WHITE;
        $this->color = ColorInterface::GREEN;
        $this->textDecoration = "******";
    }

    /**
     * @return null|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null|string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getOutputLine()
    {
        return $this->outputLine;
    }

    /**
     * @param string $outputLine
     */
    public function setOutputLine($outputLine)
    {
        $this->outputLine = $outputLine;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param int $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param int $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return string
     */
    public function getTextDecoration()
    {
        return $this->textDecoration;
    }

    /**
     * @param string $textDecoration
     */
    public function setTextDecoration($textDecoration)
    {
        $this->textDecoration = $textDecoration;
    }

    /**
     * @return AdapterInterface
     */
    public function getConsole()
    {
        return $this->console;
    }

    /**
     * @param AdapterInterface $console
     */
    public function setConsole($console)
    {
        $this->console = $console;
    }

    /**
     * Writes to active console.
     */
    public function write()
    {
        $this->setOutputLine("$this->textDecoration\n$this->message");

        $this->console->writeLine($this->outputLine, $this->color, $this->backgroundColor);

        $this->console->writeLine();

        $this->console->showCursor();
    }

}