<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Context class for a command
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class CommandContext
{
    /**
     * Input data
     * @var mixed
     */
    protected $data;

    /**
     * Command
     * @var string
     */
    protected $command;

    /**
     * Connection
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Raw Message
     * @var string
     */
    protected $message;

    /**
     * Attributes
     * @var ArrayCollection
     */
    public $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection;
    }

    /**
     * Get attribute
     *
     * @param string $attribute Attribute name
     *
     * @return mixed Attribute value
     */
    public function getAttribute($attribute)
    {
        return $this->attributes->get($attribute);
    }

    /**
     * Set Attribute
     *
     * @param string $attribute Attribute key
     * @param mixed  $value     Attribute value
     */
    public function setAttribute($attribute, $value)
    {
        $this->attributes->set($attribute, $value);

        return $this;
    }

    /**
     * Get Data
     *
     * @return mixed Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data
     *
     * @param mixed $data Data
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get Command
     *
     * @return Command Command
     */
    public function getCommand()
    {
        return $this->command;
    }
    
    /**
     * Set Command
     *
     * @param string $command Command name
     */
    public function setCommand($command)
    {
        $this->command = $command;
    
        return $this;
    }

    /**
     * Get Connection
     *
     * @return ConnectionInterface Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set Connection
     *
     * @param ConnectionInterface $connection Connection
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    
        return $this;
    }

    /**
     * Get Message
     *
     * @return string Raw message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set Message
     *
     * @param string $message Raw message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
