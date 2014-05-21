<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;
use Touki\ChatBundle\User;
use Touki\ChatBundle\UserCollection;

/**
 * Chat message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UsersAre implements Message
{
    protected $users;

    /**
     * Constructor
     *
     * @param UserCollection $users User
     */
    public function __construct(UserCollection $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'DALIST';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->users->map(function(User $user) {
            return $user->getName();
        });
    }
}
