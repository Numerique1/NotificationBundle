<?php
namespace Numerique1\Bundle\NotificationBundle\Factory;

/**
 * Used to easily retrieve NotificationFactory services
 * Class NotificationFactoryContainer
 * @package Numerique1\Bundle\NotificationBundle\Factory
 */
class NotificationFactoryContainer
{
    /**
     * Array of NotificationFactoryInterface
     * @var array
     */
    protected $builders;


    public function __construct()
    {
        $this->factories = array();
    }

    /**
     * Add factory on container
     * @param $serviceId
     * @param NotificationFactoryInterface $factory
     */
    public function addFactory($serviceId, NotificationFactoryInterface $factory)
    {
        $this->factories[$serviceId] = $factory;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function getFactory($name)
    {
        if(array_key_exists($name, $this->factories))
        {
            return $this->factories[$name];
        }
        else
        {
            throw new \Exception(sprintf('Factory %s not found', $name));
        }
    }
}