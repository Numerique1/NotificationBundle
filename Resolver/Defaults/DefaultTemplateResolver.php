<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Defaults;

class DefaultTemplateResolver implements TemplateResolverInterface
{
    /**
     * @param $entity
     * @return string
     */
    public function resolve($entity, array $config)
    {
        return $config['template'];
    }
}