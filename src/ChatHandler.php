<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Message component to handle chats
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class ChatHandler implements MessageComponentInterface
{
    /**
     * Kernel
     * @var Kernel
     */
    protected $kernel;

    /**
     * Constructor
     *
     * @param Kernel $kernel Chat Kernel
     */
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritDoc}
     */
    public function onOpen(ConnectionInterface $connection)
    {
        $this->kernel->handleConnection($connection);
    }

    /**
     * {@inheritDoc}
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->kernel->handle($from, $msg);
    }

    /**
     * {@inheritDoc}
     */
    public function onClose(ConnectionInterface $connection)
    {
        $this->kernel->handle($connection, '{"cmd":"BAI","data":null}');
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}
