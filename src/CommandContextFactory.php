<?php

namespace Touki\ChatBundle;

use Touki\ChatBundle\Exception\ParseException;
use Ratchet\ConnectionInterface;

/**
 * Command factory knows how to create Commands from userdata
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class CommandContextFactory
{
    /**
     * Builds a Command
     *
     * @param mixed $data User data
     *
     * @return CommandContext
     */
    public function build(ConnectionInterface $connection, $input)
    {
        $data = json_decode($input, true);

        if (null === $data) {
            throw new ParseException($input, "Unparsable");
        }

        if (!is_array($data)) {
            throw new ParseException($input, "Is not an array");
        }

        if (!isset($data['cmd'])) {
            throw new ParseException($input, "Has no command");
        }

        if (!array_key_exists('data', $data)) {
            throw new ParseException($input, "Has no data");
        }

        $cmd = strtoupper($data['cmd']);

        $context = new CommandContext;
        $context->setData($data['data']);
        $context->setCommand($cmd);
        $context->setConnection($connection);
        $context->setMessage($input);

        return $context;
    }
}
