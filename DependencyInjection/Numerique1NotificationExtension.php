<?php

namespace Numerique1\Bundle\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class Numerique1NotificationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('numerique1_notification.notification_factory.class', $config['factory_class']);
        $container->setParameter('numerique1_notification.notification.class', $config['notification_class']);
        unset($config['factory_class']);
        $container->setParameter('numerique1_notification.configs', $this->parseConfig($config['notifications']));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }


    /**
     * Does whatever is needed to transform the config in an acceptable argument for the factory
     * @param array $configs
     * @return array
     */
    public function parseConfig(array $configs)
    {
        foreach ($configs as $name => $config)
        {
            $configs[$config['class']] = $configs[$name];
            unset($configs[$config['class']]['class']);
            unset($configs[$name]);
        }

        return $configs;
    }
}