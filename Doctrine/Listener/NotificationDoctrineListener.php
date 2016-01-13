<?php
namespace Numerique1\Bundle\NotificationBundle\Doctrine\Listener;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;
use Doctrine\ORM\EntityManager;
class NotificationDoctrineListener
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    protected $class
    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, $notificationClass)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->class           = $notificationClass;
    }

    /**
     * Post update event process
     *
     * @param LifecycleEventArgs $args
     * @return $this
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->eventDispatcher
            ->dispatch('numerique1.notification.event.entity_post_update', $this->getNotificationEvent($args));
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
        $this->eventDispatcher
            ->dispatch('numerique1.notification.event.entity_post_persist', $this->getNotificationEvent($args));
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
        $em = $args->getEntityManager();
        $this->eventDispatcher
            ->dispatch('numerique1.notification.event.entity_post_remove', $this->getNotificationEvent($args));
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
        $this->eventDispatcher
            ->dispatch('numerique1.notification.event.entity_pre_remove', $this->getNotificationEvent($args));

        $notifications = $em->getRepository($this->class)->findBy(array(
            'targetClass' => ClassUtils::getClass($args->getEntity()),
            'targetId' => $args->getEntity()->getId()
        ));

        foreach($notifications as $notification)
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
        $event = new NotificationEvent($args->getEntity());
        return $event;
    }
}