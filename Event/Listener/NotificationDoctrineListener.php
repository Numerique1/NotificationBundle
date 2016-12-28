<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Listener;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Numerique1\Bundle\NotificationBundle\Event\Events\PostPersistNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PostRemoveNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PostUpdateNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\Factory\PreBuildNotificationEventFactory;
use Numerique1\Bundle\NotificationBundle\Event\PreUpdateNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Rule\RuleProvider;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;

class NotificationDoctrineListener
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var PreBuildNotificationEventFactory
     */
    protected $factory;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param RuleProvider $ruleProvider
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, PreBuildNotificationEventFactory $factory)
    {
        $this->eventDispatcher  = $eventDispatcher;
        $this->factory          = $factory;
    }


    /**
     * Pre update event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $event = $this->createEvent($args, PreBuildNotificationEvent::EVENT_NAME_PRE_UPDATE);
        if($event){
            $this->eventDispatcher
                ->dispatch(PreBuildNotificationEvent::EVENT_NAME_PRE_UPDATE, $event);
        }

        return $this;
    }

    /**
     * Post update event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $event = $this->createEvent($args, PreBuildNotificationEvent::EVENT_NAME_POST_UPDATE);
        if($event){
            $this->eventDispatcher
                ->dispatch(PreBuildNotificationEvent::EVENT_NAME_POST_UPDATE, $event);
        }

        return $this;
    }

    /**
     * Post persist event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $event = $this->createEvent($args, PreBuildNotificationEvent::EVENT_NAME_POST_PERSIST);
        if($event){
            $this->eventDispatcher
                ->dispatch(PreBuildNotificationEvent::EVENT_NAME_POST_PERSIST, $event);
        }

        return $this;
    }

    /**
     * Post remove event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $event = $this->createEvent($args, PreBuildNotificationEvent::EVENT_NAME_POST_REMOVE);
        if($event){
            $this->eventDispatcher
                ->dispatch(PreBuildNotificationEvent::EVENT_NAME_POST_REMOVE, $event);
        }

        return $this;
    }

    public function createEvent(LifecycleEventArgs $args, $eventName){
        return $this->factory->create($eventName, $args->getEntity(), array('em' => $args->getEntityManager()));
    }
}