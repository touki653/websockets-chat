<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Error
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Error implements Message
{
    /**
     * UserError
     * @var string
     */
    protected $error;

    /**
     * Constructor
     *
     * @param string $error InputError
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return 'ERROR';
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->error;
    }
}
