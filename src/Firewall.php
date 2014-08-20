<?php

namespace Touki\ChatBundle;

use Ratchet\ConnectionInterface;

/**
 * Firewall checks users by their IPs
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Firewall
{
    protected $firewall;

    /**
     * Constructor
     *
     * @param array $whitelist IP Whitelist
     */
    public function __construct(array $whitelist)
    {
        $this->whitelist = $whitelist;
    }

    /**
     * Is allowed
     *
     * @param ConnectionInterface $connection Connection to check
     *
     * @return boolean
     */
    public function isAllowed(ConnectionInterface $connection)
    {
        return in_array($connection->remoteAddress, $this->whitelist);
    }
}
