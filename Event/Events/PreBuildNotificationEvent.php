<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Events;

use Symfony\Component\EventDispatcher\Event;

class PreBuildNotificationEvent extends Event
{

    #Manually triggered event
    const EVENT_NAME_CONTROLLER      = 'numerique1.notification.event.controller';
    #Doctrine events
    const EVENT_NAME_PRE_PERSIST     = 'numerique1.notification.event.entity_pre_persist';
    const EVENT_NAME_POST_PERSIST    = 'numerique1.notification.event.entity_post_persist';
    const EVENT_NAME_PRE_UPDATE      = 'numerique1.notification.event.entity_pre_update';
    const EVENT_NAME_POST_UPDATE     = 'numerique1.notification.event.entity_post_update';
    const EVENT_NAME_PRE_REMOVE      = 'numerique1.notification.event.entity_pre_remove';
    const EVENT_NAME_POST_REMOVE     = 'numerique1.notification.event.entity_post_remove';

    /**
     * @var mixed
     */
    protected $entity;

    /**
     * Array of extra data
     * @var array
     */
    protected $extra;

    /**
     * Notification rule
     * @var array
     */
    protected $rule;

    /**
     * @param $entity
     * @param array $extra
     */
    public function __construct($entity, array $rule, $extra = array())
    {
        $this->entity = $entity;
        $this->extra = $extra;
        $this->rule = $rule;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    /**
     * @return array
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param array $rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }
}