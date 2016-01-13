<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Container;

class NotifiablesResolverContainer
{
    /**
     * @var UsersResolverInterface[] resolvers
     */
    protected $resolvers;

    public function __construct()
    {
        $this->resolvers = array();
    }

    /**
     * Add resolver to list
     *
     * @param UsersResolverInterface $resolver
     */
    public function addResolver($serviceId, UsersResolverInterface $resolver)
    {
        $this->resolvers[$serviceId] = $resolver;
    }

    /**
     * @param $name
     * @return UsersResolverInterface
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