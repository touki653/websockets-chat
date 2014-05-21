<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;
use Touki\ChatBundle\User;

/**
 * Chat message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Chat implements Message
{
    protected $content;
    protected $from;

    /**
     * Constructor
     *
     * @param User   $from    User sender
     * @param string $content Message content
     */
    public function __construct(User $from, $content)
    {
        $this->from    = $from;
        $this->content = $content;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'MSG';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return [
            'from' => $this->from->getName(),
            'content' => $this->content
        ];
    }
}
