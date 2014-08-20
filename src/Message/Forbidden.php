<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Forbidden message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Forbidden implements Message
{
    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'EHRMNO';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
    }
}
