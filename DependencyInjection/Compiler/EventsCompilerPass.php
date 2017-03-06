<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class EventsCompilerPass
 * @package Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler
 * @author shuyqck <nicolas.duvollet@numerique1.fr>
 */
class EventsCompilerPass implements CompilerPassInterface
{
    const SERVICE_KEY    = 'numerique1_notification.event.handler.notification_factory_handler';
    const DISPATCHER_KEY = 'event_dispatcher';

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::SERVICE_KEY)) {
            return;
        }

        $dispatcher = $container->findDefinition(self::DISPATCHER_KEY);

        $eventNames = array(
            PreBuildNotificationEvent::EVENT_NAME_CONTROLLER,
            PreBuildNotificationEvent::EVENT_NAME_PRE_PERSIST,
            PreBuildNotificationEvent::EVENT_NAME_POST_PERSIST,
            PreBuildNotificationEvent::EVENT_NAME_PRE_UPDATE,
            PreBuildNotificationEvent::EVENT_NAME_POST_UPDATE,
            PreBuildNotificationEvent::EVENT_NAME_PRE_REMOVE,
            PreBuildNotificationEvent::EVENT_NAME_POST_REMOVE
        );

        foreach ($eventNames as $eventName) {
            $dispatcher->addMethodCall(
                'addListenerService',
                array($eventName, array(self::SERVICE_KEY, 'handle'))
            );
        }
    }
}
