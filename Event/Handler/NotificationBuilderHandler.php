<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Handler;

use Doctrine\Common\Util\ClassUtils;
use Numerique1\Bundle\NotificationBundle\Builder\NotificationBuilderContainer;
use Numerique1\Bundle\NotificationBundle\Event\Events\HandleableNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PostBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;
use Numerique1\Bundle\NotificationBundle\Factory\NotificationFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class NotificationBuilderHandler
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var NotificationBuilderContainer
     */
    protected $notificationBuilderContainer;

    public function __construct(EventDispatcherInterface $eventDispatcher, NotificationBuilderContainer $notificationBuilderContainer)
    {
        $this->eventDispatcher  = $eventDispatcher;
        $this->notificationBuilderContainer = $notificationBuilderContainer;
    }

    /**
     * Handle event
     * @param NotificationEvent $event
     * @throws \Exception
     */
    public function handle(PreBuildNotificationEvent $event)
    {
        $rule = $event->getRule();

        $builder = $this->notificationBuilderContainer->getBuilder($rule['builder']);
        $builder->process($builder->build($event));
    }
}