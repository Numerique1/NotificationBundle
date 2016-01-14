<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver;

interface NotifiablesResolverInterface
{
    /**
     * @param $entity
     * @param array $parameters
     * @return mixed
     */
    public function resolve($entity, $parameters = array());
}