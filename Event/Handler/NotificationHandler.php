<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Handler;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Numerique1\Bundle\NotificationBundle\Entity\Notification;
use Numerique1\Bundle\NotificationBundle\Resolver\TemplateResolverContainer;
use Numerique1\Bundle\NotificationBundle\Resolver\UsersResolverContainer;
use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;
use Numerique1\Bundle\NotificationBundle\Factory\NotificationFactoryInterface;

class NotificationHandler
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var NotificationFactoryInterface
     */
    protected $factory;

    /**
     * @var array
     */
    protected $config;


    public function __construct(ContainerInterface $container, NotificationFactoryInterface $factory, array $config) {
        $this->config           = $config;
        $this->container        = $container;
        $this->factory          = $factory;
    }


    /**
     * Handle event
     * @param NotificationEvent $event
     * @throws \Exception
     */
    public function handle(NotificationEvent $event)
    {
        if(null === $this->container->get('security.context')->getToken()) {
            return;
        }
        $entity = $event->getEntity();
        $entityClass = ClassUtils::getClass($entity);
        $config = $this->getConfig($entityClass);
        /*Check if entity has config, if not we do not handle*/
        if($config){
            $request = $this->container->get('request');
            $route = $request->attributes->get('_controller');
            /*Find matching rules on entity configuration*/
            $matchingRules = array();
            foreach($config['rules'] as $rule)
            {
                if(
                    $event->getName() === $rule['event'] &&
                    ($rule['route'] === '*' || ($rule['route'] !== '*' && $rule['route'] === $route))
                ) {
                    $matchingRules[] = $rule;
                }
            }
            /* If more than one rule,
             * we remove rules which has no route specified to get more specific rule
             */
            if(count($matchingRules) > 1)
            {
                foreach($martchingRules as $index => $mrule)
                {
                    if($mrule['route'] === '*')
                    {
                        unset($matchingRules[$index]);
                    }
                }
                if(count($matchingRules) > 1)
                {
                    throw new \Exception('There is more than one notification rule matching for entity '.$entityClass);
                }
            }
            if(count($matchingRules) > 0)
            {
                $rule = $matchingRules[0];
                $this->factory->create($event, $rule);
            }
        }
    }

    /**
     * Return config for an entityClass
     * @param $entityClass
     */
    public function getConfig($entityClass)
    {
        if(array_key_exists($entityClass,$this->config))
        {
            return $this->config[$entityClass];
        }
        return;
    }
}