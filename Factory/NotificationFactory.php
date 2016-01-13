<?php
namespace Numerique1\Bundle\NotificationBundle\Factory;

use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;

class NotificationFactory implements NotificationFactoryInterface
{
    public function __construct();

    public function create(NotificationEvent $event ,array $rule);
}