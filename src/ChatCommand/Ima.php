<?php

namespace Touki\ChatBundle\ChatCommand;

use Ratchet\ConnectionInterface;
use Touki\ChatBundle\Message\Welcome;
use Touki\ChatBundle\Message\UsersAre;
use Touki\ChatBundle\User;
use Touki\ChatBundle\UserCollection;
use Touki\ChatBundle\Command;
use Touki\ChatBundle\CommandContext;
use Touki\ChatBundle\Messenger;

/**
 * Ima command logs users
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Ima implements Command
{
    /**
     * Users
     * @var UserCollection
     */
    protected $users;

    /**
     * Constructor
     *
     * @param UserCollection $users Users
     */
    public function __construct(UserCollection $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritDoc}
     */
    public function matches(CommandContext $context)
    {
        return 'IMA' === $context->getCommand();
    }

    /**
     * {@inheritDoc}
     */
    public function execute(CommandContext $context, Messenger $messenger)
    {
        $connection = $context->getConnection();

        if (null !== $user = $this->users->matches($connection)) {
            // $user->setName($context->getData());

            return;
        }

        $previous = $this->users->findUsersByName($context->getData());

        if (count($previous)) {
            foreach ($previous as $user) {
                $user->close();
                $this->users->remove($user);
            }
        }

        $user = new User($connection);
        $user->setName($context->getData());

        $this->users->add($user);

        $messenger->send($this->users, new Welcome($context->getData()));
    }
}
