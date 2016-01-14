<?php
namespace Numerique1\Bundle\NotificationBundle\Model;

/**
 * Class Notification
 * @package Numerique1\Bundle\NotificationBundle\Model
 * @author shuyqck <nicolas.duvollet@numerique1.fr>
 */
abstract class Notification
{
    protected $targetClass;

    protected $targetId;

    protected $content;

    protected $createdAt;

    /**
     * @return mixed
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }

    /**
     * @param $targetClass
     * @return $this
     */
    public function setTargetClass($targetClass)
    {
        $this->targetClass = $targetClass;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @param $targetId
     * @return $this
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}