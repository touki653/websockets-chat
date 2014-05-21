<?php

namespace Touki\ChatBundle\Exception;

/**
 * Exception to throw when recieved a message from unknown user
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UnknownUserException extends \RuntimeException
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct("I don't know who you are");
    }
}
