<?php

namespace Touki\ChatBundle;

use Touki\ChatBundle\Message\NickRequest;
use Touki\ChatBundle\Message\UnknownData;
use Touki\ChatBundle\Message\UnknownCommand;
use Touki\ChatBundle\Message\Error;
use Touki\ChatBundle\Event\CommandRequestEvent;
use Touki\ChatBundle\Event\CommandPreExecuteEvent;
use Touki\ChatBundle\Exception\UnknownCommandException;
use Touki\ChatBundle\Exception\ParseException;
use Ratchet\ConnectionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Kernel handles the whole chat messages
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class Kernel
{
    /**
     * Messenger
     * @var Messenger
     */
    protected $messenger;

    /**
     * Factory
     * @var CommandContextFactory
     */
    protected $factory;

    /**
     * Event Dispatcher
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Command Resolver
     * @var CommandResolver
     */
    protected $resolver;

    /**
     * Constructor
     *
     * @param Messenger                $messenger  Messenger
     * @param CommandContextFactory    $factory    Command Context Factory
     * @param EventDispatcherInterface $dispatcher Event Dispatcher
     * @param CommandResolver          $resolver   Command Resolver
     */
    public function __construct(Messenger $messenger, CommandContextFactory $factory, EventDispatcherInterface $dispatcher, CommandResolver $resolver)
    {
        $this->messenger  = $messenger;
        $this->factory    = $factory;
        $this->dispatcher = $dispatcher;
        $this->resolver   = $resolver;
    }

    /**
     * Handles a new socket
     *
     * @param ConnectionInterface $connection Connection
     */
    public function handleConnection(ConnectionInterface $connection)
    {
        $this->messenger->send($connection, new NickRequest);
    }

    /**
     * Handles a message
     *
     * @param ConnectionInterface $connection Connection
     * @param string              $data       Data sent by client
     */
    public function handle(ConnectionInterface $connection, $data)
    {
        try {
            $context = $this->factory->build($connection, $data);
            $event = new CommandRequestEvent($context);

            $this->dispatcher->dispatch('command.request', $event);

            $context = $event->getContext();

            unset($event);

            if (null === $command = $this->resolver->resolve($context)) {
                throw new UnknownCommandException($context->getCommand());
            }

            $event = new CommandPreExecuteEvent($context, $command);
            $this->dispatcher->dispatch('command.pre_execute', $event);

            $command = $event->getCommand();
            $context = $event->getContext();

            $command->execute($context, $this->messenger);

            unset($context);
            unset($event);
        } catch (ParseException $e) {
            $this->messenger->send($connection, new UnknownData($data));
        } catch (UnknownCommandException $e) {
            $this->messenger->send($connection, new UnknownCommand($e->getCommand()));
        } catch (\Exception $e) {
            $this->messenger->send($connection, new Error($e->getMessage()));
        }
    }

    /**
     * Handles an user leaving
     *
     * @param ConnectionInterface $connection Connection
     */
    public function handleClose(ConnectionInterface $connection)
    {
    }
}
