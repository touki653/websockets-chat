<?php

namespace Touki\ChatBundle\ChatCommand;

use Touki\ChatBundle\Message\Leaving;
use Touki\ChatBundle\User;
use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Touki\ChatBundle\Messenger;

/**
 * Kick command disconnects user
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Kick implements Command
{
    /**
     * {@inheritDoc}
     */
    public function matches(CommandContext $context)
    {
        return 'KICK' === $context->getCommand();
    }

    /**
     * {@inheritDoc}
     */
    public function execute(CommandContext $context, Messenger $messenger)
    {
        $users = $context->getAttribute('users');
        $user = $context->getAttribute('user');

        if ($user->getName() != 'Touki') {
            return;
        }

        $finds = $users->findUsersByName($context->getData());

        foreach ($finds as $find) {
            $find->close();
            $users->remove($find);
        }

        $messenger->send($users, new Leaving($context->getData()));
    }
}
