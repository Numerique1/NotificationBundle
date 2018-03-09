<?php
namespace Numerique1\Bundle\NotificationBundle\Rule;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Util\ClassUtils;
use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class RuleProvider
 * @package Numerique1\Bundle\NotificationBundle\Rule
 */
class RuleProvider
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $config;


    public function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @param $entity
     * @param $eventName
     * @throws \Exception
     */
    public function get($entity, $eventName)
    {
        if (null === $this->container->get('security.token_storage')->getToken()){
            return;
        }

        $entityClass = ClassUtils::getClass($entity);
        $config = $this->getConfig($entityClass);

        /*Check if entity has config, if not we do not handle*/
        if ($config)
        {
            $request = $this->container->get('request');
            $route = $request->attributes->get('_controller');

            /*Find matching rules on entity configuration*/
            $matchingRules = array();

            foreach ($config['rules'] as $rule)
            {
                if (
                    $eventName === $rule['event'] &&
                    ($rule['route'] === '*' || ($rule['route'] !== '*' && $rule['route'] === $route))
                )
                {
                    $matchingRules[] = $rule;
                }
            }

            /* If more than one rule,
             * we remove rules which has no route specified to get more specific rule
             */
            if (count($matchingRules) > 1)
            {
                foreach ($matchingRules as $index => $mrule)
                {
                    if ($mrule['route'] === '*')
                    {
                        unset($matchingRules[$index]);
                    }
                }

                if (count($matchingRules) > 1)
                {
                    throw new \Exception('There is more than one notification rule matching for entity ' . $entityClass);
                }
            }

            if (count($matchingRules) > 0)
            {
                $config['match'] = $matchingRules[0];
                return $config;
            }
        }
    }

    /**
     * Return config for an entityClass
     * @param $entityClass
     */
    public function getConfig($entityClass)
    {
        if (array_key_exists($entityClass, $this->config))
        {
            return $this->config[$entityClass];
        }

        return;
    }
}