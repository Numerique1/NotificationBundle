<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver;

interface TemplateResolverInterface
{
    /**
     * @param $entity
     * @param array $config
     * @return mixed
     */
    public function resolve($entity, array $config);
}