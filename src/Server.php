<?php

namespace Touki\ChatBundle;

use Ratchet\App;

/**
 * Server main class
 *
 * @author Touki <g.vincendon
 */
class Server
{
    /**
     * Ratchet app
     * @var App
     */
    protected $app;

    /**
     * Chat Handler
     * @var ChatHandler
     */
    protected $handler;

    /**
     * Constructor
     *
     * @param App         $app     Ratchet App
     * @param ChatHandler $handler Chat handler
     */
    public function __construct(App $app, ChatHandler $handler)
    {
        $this->app = $app;
        $this->handler = $handler;
    }

    /**
     * Runs the application
     */
    public function run($path = '/socket')
    {
        $this->app->route($path, $this->handler, ['*']);

        $this->app->run();
    }
}
