<?php

namespace Touki\ChatBundle\Exception;

/**
 * Exception to throw when recieved an non understandable command
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UnknownCommandException extends \RuntimeException
{
    /**
     * Command
     * @var string
     */
    protected $command;

    /**
     * Constructor
     *
     * @param string $data Command
     */
    public function __construct($command)
    {
        $this->command = $command;

        parent::__construct(sprintf("Command %s does not exist", $command));
    }

    /**
     * Get Command
     *
     * @return string Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
