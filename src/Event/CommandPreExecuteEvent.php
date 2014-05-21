<?php

namespace Touki\ChatBundle\Event;

use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Symfony\Component\EventDispatcher\Event;

/**
 * Command pre execute event
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class CommandPreExecuteEvent extends Event
{
    /**
     * Context
     * @var CommandContext
     */
    protected $context;

    /**
     * Command
     * @var Command
     */
    protected $command;

    /**
     * Constructor
     *
     * @param CommandContext $context Context
     * @param Command        $command Command being executed
     */
    public function __construct(CommandContext $context, Command $command)
    {
        $this->context = $context;
        $this->command = $command;
    }

    /**
     * Get Context
     *
     * @return CommandContext Command context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set Context
     *
     * @param CommandContext $context Command context
     */
    public function setContext(CommandContext $context)
    {
        $this->context = $context;
    
        return $this;
    }

    /**
     * Get Command
     *
     * @return Command Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set Command
     *
     * @param Command $command Command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    
        return $this;
    }
}
