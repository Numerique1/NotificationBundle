<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Container;

use Numerique1\Bundle\NotificationBundle\Resolver\NotifiablesResolverInterface;

class NotifiablesResolverContainer
{
    /**
     * @var NotifiablesResolverInterface[] resolvers
     */
    protected $resolvers;


    /**
     * NotifiablesResolverContainer constructor.
     */
    public function __construct()
    {
        $this->resolvers = array();
    }

    /**
     * Add resolver to list
     * @param NotifiablesResolverInterface $resolver
     */
    public function addResolver($serviceId, NotifiablesResolverInterface $resolver)
    {
        $this->resolvers[$serviceId] = $resolver;
    }

    /**
     * @param $name
     * @return NotifiablesResolverInterface
     * @throws \Exception
     */
    public function getResolver($name)
    {
        if(array_key_exists($name,$this->resolvers))
        {
            return $this->resolvers[$name];
        }else{
            throw new \Exception('Resolver not found '.$name);
        }
    }
}