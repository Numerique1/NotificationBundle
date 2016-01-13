<?php

namespace Numerique1\Bundle\NotificationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @param mixed $targetClass
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
     * @param mixed $targetId
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
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

}
