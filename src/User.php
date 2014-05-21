<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;

/**
 * User value object
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class User implements ConnectionInterface
{
    /**
     * Connection
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Name
     * @var string
     */
    protected $name;

    /**
     * Constructor
     *
     * @param ConnectionInterface $connection User connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function send($data)
    {
        return $this->connection->send($data);
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        return $this->connection->send();
    }

    /**
     * Get Connection
     *
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Get Name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set Name
     *
     * @param string $name Name
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Is same connection
     *
     * @param ConnectionInterface $connection Connection to compare
     *
     * @return boolean
     */
    public function isConnection(ConnectionInterface $connection)
    {
        return $this->connection == $connection;
    }

    /**
     * Equality
     *
     * @param User $user Is an user equals another one
     *
     * @return boolean
     */
    public function equals(User $user)
    {
        return $user->isConnection($this->connection);
    }
}
