<?php

namespace Touki\ChatBundle\ChatCommand;

use Touki\ChatBundle\Message\Leaving;
use Touki\ChatBundle\User;
use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Touki\ChatBundle\Messenger;

/**
 * Bai command disconnects users
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Bai implements Command
{
    /**
     * {@inheritDoc}
     */
    public function matches(CommandContext $context)
    {
        return 'BAI' === $context->getCommand();
    }

    /**
     * {@inheritDoc}
     */
    public function execute(CommandContext $context, Messenger $messenger)
    {
        $connection = $context->getConnection();
        $users = $context->getAttribute('users');
        $user = $context->getAttribute('user');

        $users->remove($user);

        $messenger->send($users, new Leaving($user->getName()));
    }
}
