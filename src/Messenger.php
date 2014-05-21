<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;

/**
 * Messenger knows how to send and recieve data
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Messenger
{
    /**
     * Sends a message
     *
     * @param ConnectionInterface $connection Connection socket
     * @param Message             $message    Message to send
     */
    public function send(ConnectionInterface $connection, Message $message)
    {
        $data = [
            'cmd' => $message->getCommand(),
            'data' => $message->getContent()
        ];

        $connection->send(json_encode($data));
    }
}
