# NotificationBundle

## Information

The bundle provides a facility to generate notifications (email, database, flash) in Symfony projects.

## How to use
  - First : Create some notification rules (see: [Configuration Reference](#configuration-reference))
  - Second : Create an entity which extends our Notification model and NotificationInstance (optional) (see: [Create Notification](#create-notification))
  - Then : Create a service (tagged _'numerique1_notification.notification_factory'_) which extends __NotificationFactoryInterface__. This factory is charged to create the __Notification__ object and __NotificationInstance__ object's from the __PreBuildNotificationEvent__ data's and then decide what to do with the notification. (see: [Create Factory](#create-factory))

## Create Notification
```php
<?php

namespace Acme\NotificationBundle\Entity;
use Numerique1\Bundle\NotificationBundle\Model\Notification as Base;

/**
 * @ORM\Entity()
 * @ORM\Table(name="acme_notification")
 */
class Notification extends Base{
    //your stuff
}
```

## Create Factory
```php
<?php

namespace Acme\NotificationBundle\Factory;

class DefaultNotificationFactory
{
    //constructor($em);
    /**
     * creates the notification with PreBuildNotificationEvent's data.
     * @param PreBuildNotificationEvent $event
     * @return Notification
     */
    public function create(PreBuildNotificationEvent $event){
        $notification = new Notification($event->getRule()['extra']['message']);
        $users = $this->em->getRepository('Acme/UserBundle/Entity/User')->findByIds($event->getRule()['extra']['users']);
        foreach($users as $user){
          $notification->createInstance($user);
        }
        $this->em->persist($notification);
        $this->em->flush();  
    }

}
```
## Configuration Reference

```php
numerique1_notification:
    notifications:
        Acme\UserBundle\Entity\User:
            reference: "user"
            rules:
            - {
                event: 'numerique1.notification.event.entity_post_update',  
                route: 'Acme\UserBundle\Controller\UserController::updateUserAction', #Default: '*'
                factory: 'numerique1_notification.default_notification_factory' #The builder which create the notification
                extra:{message: 'Some user has been updated', users: [1,2,3], yourkey: yourdata} #Some extra data you can use to generate your notification
              }

```
