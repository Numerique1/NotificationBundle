<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Factory;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Rule\RuleProvider;

/**
 * Class PreBuildNotificationEventFactory
 * @package Numerique1\Bundle\NotificationBundle\Event\Factory
 */
class PreBuildNotificationEventFactory
{
    /**
     * @var RuleProvider
     */
    protected $ruleProvider;

    public function __construct(RuleProvider $ruleProvider)
    {
        $this->ruleProvider = $ruleProvider;
    }

    /**
     * @param $entity
     * @param $eventName
     * @return mixed
     */
    public function create($eventName, $entity, array $extra = array())
    {
        if($rule = $this->ruleProvider->get($entity, $eventName)){
            return new PreBuildNotificationEvent($entity, $rule, $extra);
        }
        return null;
    }
}