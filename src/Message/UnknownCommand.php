<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Unknown command recieved
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UnknownCommand implements Message
{
    /**
     * UserCommand
     * @var string
     */
    protected $command;

    /**
     * Constructor
     *
     * @param string $command InputCommand
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'ERROR';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return sprintf("Ununderstandable command %s", $this->command);
    }
}
