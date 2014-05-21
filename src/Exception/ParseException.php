<?php

namespace Touki\ChatBundle\Exception;

/**
 * Exception to throw when recieved an non understandable data
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class ParseException extends \RuntimeException
{
    /**
     * Data sent
     * @var string
     */
    protected $data;

    /**
     * Constructor
     *
     * @param string $data  Data
     * @param string $extra Extra informations
     */
    public function __construct($data, $extra = null)
    {
        $this->data = $data;

        parent::__construct(sprintf("Couldn't parse data %s [%s]", $data, $extra));
    }

    /**
     * Get Data
     *
     * @return string Data
     */
    public function getData()
    {
        return $this->data;
    }
}
