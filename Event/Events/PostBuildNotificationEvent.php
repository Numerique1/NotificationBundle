<?php
namespace Numerique1\Bundle\NotificationBundle\Event\Events;

use Numerique1\Bundle\NotificationBundle\Model\Notification;
use Symfony\Component\EventDispatcher\Event;

class PostBuildNotificationEvent extends Event
{

    const EVENT_NAME = 'numerique1.notification.event.postbuild';

    /**
     * PreBuildNotificationEvent which has been used to generate $notfication.
     * @var PreBuildNotificationEvent
     */
    protected $preBuildEvent;

    /**
     * @var Notification
     */
    protected $notification;


    /**
     * @param Notification $notification
     */
    public function __construct(PreBuildNotificationEvent $preBuildEvent, Notification $notification)
    {
        $this->preBuildEvent    = $preBuildEvent;
        $this->notification     = $notification;
    }

    /**
     * @return PreBuildNotificationEvent
     */
    public function getPreBuildEvent()
    {
        return $this->preBuildEvent;
    }

    /**
     * @param PreBuildNotificationEvent $preBuildEvent
     */
    public function setPreBuildEvent($preBuildEvent)
    {
        $this->preBuildEvent = $preBuildEvent;
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

}