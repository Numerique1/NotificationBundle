<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Doctrine\ORM\EntityManager;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class EventsCompilerPass
 * @package Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler
 * @author shuyqck <nicolas.duvollet@numerique1.fr>
 */
class EventsCompilerPass implements CompilerPassInterface
{
    const SERVICE_KEY    = 'numerique1_notification.notification.handler';
    const DISPATCHER_KEY = 'event_dispatcher';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }

        $dispatcher = $container->getDefinition(self::DISPATCHER_KEY);

        $eventNames = array(
            'numerique1.notification.event.controller_start',
            'numerique1.notification.event.controller_end',
            'numerique1.notification.event.entity_pre_update',
            'numerique1.notification.event.entity_post_update',
            'numerique1.notification.event.entity_pre_persist',
            'numerique1.notification.event.entity_post_persist',
            'numerique1.notification.event.entity_post_remove'
        );
        foreach ($eventNames as $eventName) {
            $dispatcher->addMethodCall(
                'addListenerService',
                array($eventName, array(self::SERVICE_KEY, 'handle'))
            );
        }
    }
}
