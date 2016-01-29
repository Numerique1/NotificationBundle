<?php
namespace Numerique1\Bundle\NotificationBundle\Event;

use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;

class PreUpdateNotificationEvent extends NotificationEvent
{
    /**
     * @var array
     */
    protected $entityChangeSet;

    /**
     * @param $entity
     * @param array $entityChangeSet
     * @param array $parameters
     */
    public function __construct($entity, array $entityChangeSet, array $parameters = array())
    {
        parent::__construct($entity, $parameters);
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * @return array
     */
    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }

    /**
     * @param array $entityChangeSet
     */
    public function setEntityChangeSet($entityChangeSet)
    {
        $this->entityChangeSet = $entityChangeSet;
    }

}