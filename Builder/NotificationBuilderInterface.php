<?php
namespace Numerique1\Bundle\NotificationBundle\Builder;

use Numerique1\Bundle\NotificationBundle\Event\Events\PreBuildNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Model\Notification;

interface NotificationBuilderInterface
{
    /**
     * Build the notification with PreBuildNotificationEvent's data.
     * @param PreBuildNotificationEvent $event
     * @return Notification
     */
    public function build(PreBuildNotificationEvent $event);

    /**
     * Process Notification. ie. persist, send mail, push, log
     * @param Notification $notification
     */
    public function process(Notification $notification);
}