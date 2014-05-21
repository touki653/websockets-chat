<?php

namespace Touki\ChatBundle\ChatCommand;

use Ratchet\ConnectionInterface;
use Touki\ChatBundle\Message\Welcome;
use Touki\ChatBundle\User;
use Touki\ChatBundle\UserCollection;
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

        foreach ($context->getAttribute('users') as $user) {
            $messenger->send($user, new Chat($from, $context->getData()));
        }
    }
}
