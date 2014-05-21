<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Nick request message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class NickRequest implements Message
{
    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'WHORU';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
    }
}
