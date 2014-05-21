<?php

namespace Touki\ChatBundle\Event;

use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Symfony\Component\EventDispatcher\Event;

/**
 * Command request event
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class CommandRequestEvent extends Event
{
    /**
     * Context
     * @var CommandContext
     */
    protected $context;

    /**
     * Constructor
     *
     * @param CommandContext $context Context
     */
    public function __construct(CommandContext $context)
    {
        $this->context = $context;
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
}
