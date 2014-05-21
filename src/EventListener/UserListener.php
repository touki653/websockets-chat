<?php

namespace Touki\ChatBundle\EventListener;

use Touki\ChatBundle\Event\CommandPreExecuteEvent;
use Touki\ChatBundle\ChatCommand\Ima;
use Touki\ChatBundle\Exception\UnknownUserException;
use Touki\ChatBundle\UserCollection;

/**
 * User Event listener
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UserListener
{
    /**
     * Users
     * @var UserCollection
     */
    protected $users;

    /**
     * Constructor
     *
     * @param UserCollection $users User Collection
     */
    public function __construct(UserCollection $users)
    {
        $this->users = $users;
    }

    /**
     * On command pre execute
     *
     * @param CommandPreExecuteEvent $event Event
     */
    public function onCommandPreExecute(CommandPreExecuteEvent $event)
    {
        $command = $event->getCommand();

        if ($command instanceof Ima) {
            return;
        }

        $context = $event->getContext();

        if (null === $user = $this->users->matches($context->getConnection())) {
            throw new UnknownUserException();
        }

        $context->setAttribute('user', $user);
        $context->setAttribute('users', $this->users);
    }
}
