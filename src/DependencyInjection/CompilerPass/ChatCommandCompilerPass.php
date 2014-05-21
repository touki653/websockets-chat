<?php

namespace Touki\ChatBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Chat commands compiler pass understands chat.command service tags
 *
 * @author Touki <g.vincendon@vithemis.com>
 */
class ChatCommandCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $holder = $container->getDefinition('chat.command_resolver');

        foreach ($container->findTaggedServiceIds('chat.command') as $service => $attributes) {
            $holder->addMethodCall('add', [new Reference($service)]);
        }
    }
}
