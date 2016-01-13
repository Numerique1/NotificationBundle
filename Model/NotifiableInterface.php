<?php
namespace Numerique1\Bundle\NotificationBundle\Model;

/**
 * Interface NotifiableInterface
 * @package Numerique1\Bundle\NotificationBundle\Model
 */
interface NotifiableInterface
{
    /**
     * @return array
     */
    public function getNotifiables();
}