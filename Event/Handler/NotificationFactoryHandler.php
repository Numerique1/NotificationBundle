<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Handler;

use Doctrine\Common\Util\ClassUtils;
use Numerique1\Bundle\NotificationBundle\Factory\NotificationFactoryContainer;
use Numerique1\Bundle\NotificationBundle\Event\Events\HandleableNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PostBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Model\Notification;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;
use Numerique1\Bundle\NotificationBundle\Factory\NotificationFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NotificationFactoryHandler
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var NotificationFactoryContainer
     */
    protected $notificationFactoryContainer;

    public function __construct(EventDispatcherInterface $eventDispatcher, NotificationFactoryContainer $notificationFactoryContainer)
    {
        $this->eventDispatcher  = $eventDispatcher;
        $this->notificationFactoryContainer = $notificationFactoryContainer;
    }

    /**
     * Handle event
     * @param NotificationEvent $event
     * @throws \Exception
     */
    public function handle(PreBuildNotificationEvent $event)
    {
        $rule = $event->getRule();

        $factory = $this->notificationFactoryContainer->getFactory($rule['factory']);
        $notification = $factory->create($event);
    }
}