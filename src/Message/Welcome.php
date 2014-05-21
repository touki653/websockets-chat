<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Welcome message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Welcome implements Message
{
    /**
     * Nickname
     * @var string
     */
    protected $nick;

    /**
     * Constructor
     *
     * @param string $nick Nickname
     */
    public function __construct($nick)
    {
        $this->nick = $nick;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'WELCOME';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->nick;
    }
}
