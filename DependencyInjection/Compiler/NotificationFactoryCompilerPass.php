<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class NotificationFactoryCompilerPass
 * @package Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler
 */
class NotificationFactoryCompilerPass implements CompilerPassInterface
{
    const TAG         = 'numerique1_notification.notification_factory';
    const SERVICE_KEY = 'numerique1_notification.factory.notification_factory_container';

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
            $serviceDefinition->addMethodCall('addFactory', array($serviceId, new Reference($serviceId)));
        }
    }
}