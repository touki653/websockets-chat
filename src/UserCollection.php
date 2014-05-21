<?php

namespace Touki\ChatBundle;

use IteratorAggregate, ArrayIterator;
use Ratchet\ConnectionInterface;

/**
 * User collection
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UserCollection implements IteratorAggregate, ConnectionInterface
{
    /**
     * Users
     * @var array
     */
    protected $users = [];

    /**
     * Adds an user
     *
     * @param User $user User to add
     */
    public function add(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Removes an user
     *
     * @param User $user User to remove
     */
    public function remove(User $user)
    {
        foreach ($this->users as $key => $which) {
            if ($user->equals($which)) {
                unset($this->users[$key]);
            }
        }
    }

    /**
     * Get all users
     *
     * @return array An array of users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->users);
    }

    /**
     * Checks if a connection matches with an user
     *
     * @param ConnectionInterface $connection Connection to match
     *
     * @return User
     */
    public function matches(ConnectionInterface $connection)
    {
        foreach ($this->users as $user) {
            if ($user->isConnection($connection)) {
                return $user;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function send($data)
    {
        foreach ($this->users as $user) {
            $user->send($data);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        foreach ($this->users as $user) {
            $user->close();
        }

        return $this;
    }

    /**
     * Apply a map to the object
     *
     * @param callable $callee Function to execute
     *
     * @return array
     */
    public function map(callable $callee)
    {
        return array_values(array_map($callee, $this->users));
    }

    /**
     * Finds users by name
     *
     * @param string $name Username
     *
     * @return array
     */
    public function findUsersByName($name)
    {
        $users = [];

        foreach ($this->users as $user) {
            if ($user->getName() == $name) {
                $users[] = $user;
            }
        }

        return $users;
    }
}
