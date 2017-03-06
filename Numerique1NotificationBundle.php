<?php
namespace Numerique1\Bundle\NotificationBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler\EventsCompilerPass;
use Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler\NotificationFactoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Numerique1NotificationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NotificationFactoryCompilerPass());
        $container->addCompilerPass(new EventsCompilerPass());

        $this->addRegisterMappingsPass($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/ORM') => 'Numerique1\Bundle\NotificationBundle\Model',
        );

        if (class_exists('Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass')) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings));
        }
    }
}