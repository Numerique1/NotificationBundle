<?php
namespace Numerique1\Bundle\NotificationBundle\Doctrine\Listener;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Numerique1\Bundle\NotificationBundle\Event\PreUpdateNotificationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;

class NotificationDoctrineListener
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected $notificationEntityClass;

    /**
     * @var array
     */
    protected $notificationRules;

    /**
     * NotificationDoctrineListener constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param $notificationClass
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, $notificationEntityClass, array $notificationRules)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->notificationEntityClass = $notificationEntityClass;
        $this->notificationRules = $notificationRules;
    }

    /**
     * Pre update event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entityClass = ClassUtils::getClass($args->getEntity());
        if (array_key_exists($entityClass, $this->notificationRules))
        {
            $rules = $this->notificationRules[$entityClass];
            $event = new PreUpdateNotificationEvent($args->getEntity(), $args->getEntityChangeSet(), array(
                'em' => $args->getEntityManager(),
                'rules' => $rules
            ));
            $this->eventDispatcher
                ->dispatch('numerique1.notification.event.entity_pre_update', $event);
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
        $event = $this->getNotificationEvent($args);
        if($event){
            $this->eventDispatcher
                ->dispatch('numerique1.notification.event.entity_post_update', $event);
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
        $event = $this->getNotificationEvent($args);
        if($event){
            $this->eventDispatcher
                ->dispatch('numerique1.notification.event.entity_post_persist', $event);
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
        $event = $this->getNotificationEvent($args);
        if($event){
            $this->eventDispatcher
                ->dispatch('numerique1.notification.event.entity_post_remove', $event);
        }

        return $this;
    }

    /**
     * Pre remove event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $notifications = $em->getRepository($this->notificationEntityClass)->findBy(array(
            'targetClass' => ClassUtils::getClass($args->getEntity()),
            'targetId' => $args->getEntity()->getId()
        ));

        foreach ($notifications as $notification)
        {
            $em->remove($notification);
        }
    }

    /**
     * Create new event instance
     *
     * @param LifecycleEventArgs $args
     * @return NotificationEvent
     */
    public function getNotificationEvent(LifecycleEventArgs $args)
    {
        $entityClass = ClassUtils::getClass($args->getEntity());
        if (array_key_exists($entityClass, $this->notificationRules))
        {
            $rules = $this->notificationRules[$entityClass];
            $event = new NotificationEvent($args->getEntity(), array(
                'em' => $args->getEntityManager(),
                'rules' => $rules
            ));
            return $event;
        }

        return false;
    }
}