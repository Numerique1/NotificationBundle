<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver;

interface NotifiablesResolverInterface
{
    /**
     * @param $entity
     * @return array
     */
    public function resolve($entity, $parameters = array());
}