<?php

namespace Touki\ChatBundle\Message;

use Touki\ChatBundle\Message;

/**
 * Unknown data recieved
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class UnknownData implements Message
{
    /**
     * UserData
     * @var string
     */
    protected $data;

    /**
     * Constructor
     *
     * @param string $data InputData
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        return sprintf("Ununderstandable data %s", $this->data);
    }
}
