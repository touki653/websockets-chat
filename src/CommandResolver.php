<?php

namespace Touki\ChatBundle;

/**
 * Command resolver knows commands and how to choose them
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class CommandResolver
{
    /**
     * Commands
     * @var array
     */
    protected $commands = [];

    /**
     * Adds a command
     *
     * @param Command $command Command
     */
    public function add(Command $command)
    {
        $this->commands[] = $command;
    }

    /**
     * Resolves a command from a given context
     *
     * @param CommandContext $context Context
     *
     * @return Command
     */
    public function resolve(CommandContext $context)
    {
        if ((null !== $command = $context->getAttribute('_command'))
            && ($command instanceof Command)
        ) {
            return $command;
        }

        foreach ($this->commands as $command) {
            if (true === $command->matches($context)) {
                return $command;
            }
        }
    }
}
