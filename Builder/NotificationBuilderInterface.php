<?php
namespace Numerique1\Bundle\NotificationBundle\Builder;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Model\Notification;

interface NotificationBuilderInterface
{
    /**
     * @param PreBuildNotificationEvent $event
     * @return Notification
     */
    public function build(PreBuildNotificationEvent $event);
}