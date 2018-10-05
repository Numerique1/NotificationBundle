<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Handler\NotificationFactoryHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventsCompilerPass
 * @package Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler
 * @author shuyqck <nicolas.duvollet@numerique1.fr>
 */
class EventsCompilerPass implements CompilerPassInterface
{
    const SERVICE_KEY = NotificationFactoryHandler::class;
    const DISPATCHER_KEY = EventDispatcherInterface::class;

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addCompilerPass(new RegisterListenersPass(EventDispatcher::class, 'numerique1_notification.event_subscriber', 'numerique1_notification.event_subscriber'));
    }
}
