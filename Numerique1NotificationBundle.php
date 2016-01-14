<?php
namespace Numerique1\Bundle\NotificationBundle;

use FOS\UserBundle\DependencyInjection\Compiler\RegisterMappingsPass;
use Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler\EventsCompilerPass;
use Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler\NotifiablesResolverCompilerPass;
use Numerique1\Bundle\NotificationBundle\DependencyInjection\Compiler\TemplateResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Numerique1NotificationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NotifiablesResolverCompilerPass());
        $container->addCompilerPass(new TemplateResolverCompilerPass());
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

        $container->addCompilerPass(RegisterMappingsPass::createOrmMappingDriver($mappings));
    }
}
