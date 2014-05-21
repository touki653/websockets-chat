<?php

namespace Touki\ChatBundle\ChatCommand;

use Touki\ChatBundle\User;
use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Touki\ChatBundle\Messenger;
use Touki\ChatBundle\Message\Chat;

/**
 * Message command sends a message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Message implements Command
{
    /**
     * {@inheritDoc}
     */
    public function matches(CommandContext $context)
    {
        return 'MSG' === $context->getCommand();
    }

    /**
     * {@inheritDoc}
     */
    public function execute(CommandContext $context, Messenger $messenger)
    {
        $from = $context->getAttribute('user');

        $messenger->send($context->getAttribute('users'), new Chat($from, $context->getData()));
    }
}
