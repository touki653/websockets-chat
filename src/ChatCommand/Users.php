<?php

namespace Touki\ChatBundle\ChatCommand;

use Touki\ChatBundle\User;
use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Touki\ChatBundle\Messenger;
use Touki\ChatBundle\Message\UsersAre;

/**
 * Users command lists users
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Users implements Command
{
    /**
     * {@inheritDoc}
     */
    public function matches(CommandContext $context)
    {
        return 'GIMELIST' === $context->getCommand();
    }

    /**
     * {@inheritDoc}
     */
    public function execute(CommandContext $context, Messenger $messenger)
    {
        $users = $context->getAttribute('users');
        $user = $context->getAttribute('user');

        $messenger->send($user, new UsersAre($users));
    }
}
