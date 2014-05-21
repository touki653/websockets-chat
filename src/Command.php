<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;

/**
 * Base interface for chat commands
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
interface Command
{
    /**
     * Check if the command matches with the name
     *
     * @param CommandContext $context Context
     *
     * @return boolean
     */
    public function matches(CommandContext $context);

    /**
     * Executes the command
     *
     * @param CommandContext $context   Parsed data
     * @param Messenger      $messenger Messenger
     */
    public function execute(CommandContext $context, Messenger $messenger);
}
