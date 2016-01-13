<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class NotifiablesResolverCompilerPass
 * @package Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler
 * @author shuyqck <nicolas.duvollet@numerique1.fr>
 */
class NotifiablesResolverCompilerPass implements CompilerPassInterface
{
    const TAG         = 'numerique1_notification.notifiables_resolver';
    const SERVICE_KEY = 'numerique1_notification.notifiables_resolver.container';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }

        $serviceDefinition = $container->getDefinition(self::SERVICE_KEY);
        $taggedServices = $container->findTaggedServiceIds(self::TAG);

        foreach ($taggedServices as $serviceId => $taggedService) {
            $serviceDefinition->addMethodCall('addResolver', array($serviceId, new Reference($serviceId)));
        }
    }
}
