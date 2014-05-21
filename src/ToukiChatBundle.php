<?php

namespace Touki\ChatBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Touki\ChatBundle\DependencyInjection\CompilerPass\ChatCommandCompilerPass;

/**
 * Bundle declaration for ToukiChat
 */
class ToukiChatBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ChatCommandCompilerPass);
    }
}
