<?php
namespace Numerique1\Bundle\NotificationBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class NotificationEvent extends Event
{
    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @var array
     */
    protected $parameters;


    /**
     * NotificationEvent constructor.
     * @param $entity
     * @param array $parameters
     */
    public function __construct($entity, $parameters = array())
    {
        $this->entity = $entity;
        $this->parameters = $parameters;
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
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}