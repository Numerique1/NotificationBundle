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
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationFactoryHandler implements EventSubscriberInterface
{

    public static function getSubscribedEvents(){
        return [
            PreBuildNotificationEvent::EVENT_NAME_PRE_PERSIST => "handle",
            PreBuildNotificationEvent::EVENT_NAME_POST_PERSIST => "handle",
            PreBuildNotificationEvent::EVENT_NAME_PRE_UPDATE => "handle",
            PreBuildNotificationEvent::EVENT_NAME_POST_UPDATE => "handle",
            PreBuildNotificationEvent::EVENT_NAME_PRE_REMOVE => "handle",
            PreBuildNotificationEvent::EVENT_NAME_POST_REMOVE => "handle",
            PreBuildNotificationEvent::EVENT_NAME_CONTROLLER => "handle"
        ];
    }

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var NotificationFactoryContainer
     */
    protected $notificationFactoryContainer;

    public function __construct($eventDispatcher, NotificationFactoryContainer $notificationFactoryContainer)
    {
        $this->eventDispatcher  = $eventDispatcher;
        $this->notificationFactoryContainer = $notificationFactoryContainer;
    }

    /**
     * Handle event
     * @param NotificationEvent $event
     * @throws \Exception
     */
    public function handle(Event $event)
    {
        if($event instanceof PreBuildNotificationEvent){
            $rule = $event->getRule();
            $factory = $this->notificationFactoryContainer->getFactory($rule['factory']);
            $factory->create($event);
        }
    }
}