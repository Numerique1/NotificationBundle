<?php
namespace Numerique1\Bundle\NotificationBundle\Builder;

/**
 * Used to easily retrieve NotificationBuilders services
 * Class NotificationBuilderContainer
 * @package Numerique1\Bundle\NotificationBundle\Builder
 */
class NotificationBuilderContainer
{
    /**
     * Array of NotificationBuilderInterface
     * @var array
     */
    protected $builders;


    public function __construct()
    {
        $this->builders = array();
    }

    /**
     * Add builder on container
     * @param $serviceId
     * @param NotificationBuilderInterface $builder
     */
    public function addBuilder($serviceId, NotificationBuilderInterface $builder)
    {
        $this->builders[$serviceId] = $resolver;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function getBuilder($name)
    {
        if(array_key_exists($name, $this->builders))
        {
            return $this->builder[$name];
        }
        else
        {
            throw new \Exception('Resolver not found '.$name);
        }
    }
}