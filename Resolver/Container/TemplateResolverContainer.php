<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Container;

use Numerique1\Bundle\NotificationBundle\Resolver\TemplateResolverInterface;

class TemplateResolverContainer
{
    /**
     * @var TemplateResolverInterface[] resolvers
     */
    protected $resolvers;


    public function __construct()
    {
        $this->resolvers = array();
    }

    /**
     * Add resolver to list
     * @param $serviceId
     * @param TemplateResolverInterface $resolver
     */
    public function addResolver($serviceId, TemplateResolverInterface $resolver)
    {
        $this->resolvers[$serviceId] = $resolver;
    }

    /**
     * @param $name
     * @return TemplateResolverInterface
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