<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Defaults;

use Numerique1\Bundle\NotificationBundle\Resolver\TemplateResolverInterface;

class DefaultTemplateResolver implements TemplateResolverInterface
{
    /**
     * @param $entity
     * @param array $config
     * @return mixed
     */
    public function resolve($entity, array $config)
    {
        return $config['template'];
    }
}