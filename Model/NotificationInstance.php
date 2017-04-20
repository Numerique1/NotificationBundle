<?php
namespace Numerique1\Bundle\NotificationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Notification
 * @package Numerique1\Bundle\NotificationBundle\Model
 */
class NotificationInstance
{

    const STATE_NEW = 0;
    const STATE_READ = 1;

    /**
     * Mapped - Id of the instance
     * @var integer
     */
    private $id;

    /**
     * Mapped - Notification
     * @var string
     */
    private $notification;

    /**
     * Mapped - User to notify
     * @var UserInterface
     */
    private $recipient;

    /**
     * Mapped - Instance state. ie. new, read
     * @var string
     */
    private $state;

    /**
     * @param Notification $notification
     * @param UserInterface $recipient
     */
    public function __construct(Notification $notification, UserInterface $recipient){
        $this->state = self::STATE_NEW;
        $this->notification = $notification;
        $this->recipient = $recipient;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param string $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return array
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param array $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
}