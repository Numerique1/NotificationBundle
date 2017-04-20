<?php
namespace Numerique1\Bundle\NotificationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Notification
 * @package Numerique1\Bundle\NotificationBundle\Model
 */
class Notification implements NotificationInterface
{
    /**
     * Non-mapped - List of UserInterface used to create NotificationInstance.
     * @var ArrayCollection
     */
    private $recipients;

    /**
     * Non-mapped - Notification instances.
     * @var ArrayCollection
     */
    private $instances;

    /**
     * Mapped - Id of the notification
     * @var integer
     */
    private $id;

    /**
     * Mapped - A human readable text of notification.
     * @var string
     */
    private $message;

    /**
     * Mapped - Notification metadata.
     * @var array
     */
    private $meta = array();

    /**
     * @param $message
     * @param array $meta
     */
    public function __construct($message, array $meta = array()){
        $this->recipients = new ArrayCollection();
        $this->instances = new ArrayCollection();

        $this->message = $message;
        $this->meta = $meta;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    /**
     * Get the value of recipients.
     *
     * @return mixed recipients
     *
     */
    public function getRecipients(){
        return $this->recipients;
    }

    /**
     * Sets the value of recipients.
     *
     * @param mixed recipients
     * @return $this
     */
    public function setRecipients($recipients){
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Add element on recipients collection.
     *
     * @param mixed recipients
     * @return $this
     */
    public function addRecipient($recipient)
    {
        if(!$this->recipients->contains($recipient))
        {
            $this->recipients->add($recipient);
        }
        return $this;
    }

    /**
     * Remove element from recipients collection.
     *
     * @param mixed recipients
     * @return $this
     */
    public function removeRecipient($recipient)
    {
        if($this->recipients->contains($recipient))
        {
            $this->recipients->removeElement($recipient);
        }
        return $this;
    }

    /**
     * Get the value of instances.
     *
     * @return mixed instances
     *
     */
    public function getInstances(){
        return $this->instances;
    }

    /**
     * Sets the value of instances.
     *
     * @param mixed instances
     * @return $this
     */
    public function setInstances($instances){
        $this->instances = $instances;
        return $this;
    }

    /**
     * Add element on instances collection.
     *
     * @param mixed instances
     * @return $this
     */
    public function addInstance($instance)
    {
        if(!$this->instances->contains($instance))
        {
            $instance->setNotification($this);
            $this->instances->add($instance);
        }
        return $this;
    }

    /**
     * Remove element from instances collection.
     *
     * @param mixed instances
     * @return $this
     */
    public function removeInstance($instance)
    {
        if($this->instances->contains($instance))
        {
            $instances->setNotification(null);
            $this->instances->removeElement($instance);
        }
        return $this;
    }

    /**
     * Creates NotificationInstance from UserInterface.
     * @param UserInterface $recipient
     * @return $this
     */
    public function createInstance(UserInterface $recipient){
        $instance = new NotificationInstance($this, $recipient);
        $this->addInstance($instance);
        return $instance;
    }
}