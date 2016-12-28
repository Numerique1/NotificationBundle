<?php
namespace Numerique1\Bundle\NotificationBundle\Pool;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;

/**
 * This class is used to be able to persist pre-update events.
 * NotificationPool will persist/flush notifications on postFlush event
 * exemple:
 *  $noticationPool->addNotification($notification);
 *
 * Class NotificationPool
 * @package Numerique1\Bundle\NotificationBundle\Pool
 */
class NotificationPool
{
    /**
     * @var array
     */
    protected $notifications = array();

    /**
     * Adds entity to persist.
     *
     * @param object $entity
     */
    public function addNotification($entity)
    {
        $this->notifications[] = $entity;
    }

    /**
     * @param EntityManagerInterface $em
     * @return bool
     */
    public function persistClear(EntityManagerInterface $em)
    {
        if (!$this->notifications) {
            return false;
        }
        foreach ($this->notifications as $entity) {
            $em->persist($entity);
        }
        $this->notifications = array();
        return true;
    }

    /**
     * @param EntityManagerInterface $em
     * @return bool
     */
    public function persistFlush(EntityManagerInterface $em)
    {
        if ($this->persistClear($em)) {
            $em->flush();
            return true;
        }
        return false;
    }

    /**
     * Persist and flush pooled notifications
     * @param PostFlushEventArgs $event
     */
    public function postFlush(PostFlushEventArgs $event){
        if(!empty($this->notifications)) {
            $em = $event->getEntityManager();
            $this->persistFlush($em);
        }
    }
}