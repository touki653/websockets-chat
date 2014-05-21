<?php

namespace Touki\ChatBundle;

/**
 * Message to implement to send a new message
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
interface Message
{
    /**
     * Get Command
     *
     * @return string Command
     */
    public function getCommand();

    /**
     * Get content
     *
     * @return string Content
     */
    public function getContent();
}
