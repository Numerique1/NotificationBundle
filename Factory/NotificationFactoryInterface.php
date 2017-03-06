<?php
namespace Numerique1\Bundle\NotificationBundle\Factory;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Model\Notification;

interface NotificationFactoryInterface
{
    /**
     * Creates and process Notification and NotificationInstances.
     * @param PreBuildNotificationEvent $event
     */
    public function create(PreBuildNotificationEvent $event);

}