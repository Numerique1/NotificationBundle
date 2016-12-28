# NotificationBundle

## Information

The bundle provides a facility to generate notifications (email, database, flash) in Symfony projects.

## How to use
  - First : Create some notification rules (see: "Configuration Reference")
  - Then : Create a service (tagged _'numerique1_notification.notification_builder'_) which extends __NotificationBuilderInterface__. This builder will create the __Notification__ object from the __PreBuildNotificationEvent__ data's and then decide what to do with the notification. (see: "Build Notification")

## Build Notification
```php
<?php

namespace Acme\NotificationBundle\Builder;

class DefaultNotificationBuilder
{
    //constructor($em);
    /**
     * Build the notification with PreBuildNotificationEvent's data.
     * @param PreBuildNotificationEvent $event
     * @return Notification
     */
    public function build(PreBuildNotificationEvent $event){
        $notification = new Notification($event->getRule()['extra']['message']);
        $users = $this->em->getRepository('Acme/UserBundle/Entity/User')->findByIds($event->getRule()['extra']['users']);
        foreach($users as $user){
          $notification->createInstance($user);
        }
        return $notification;
    }

    /**
     * Process Notification. ie. persist, send mail, push, log
     * @param Notification $notification
     */
    public function process(Notification $notification){
      $this->em->persist($notification);
      $this->em->flush();
    }
}
```
## Configuration Reference

```php
numerique1_notification:
    notifications:
        acme:
            class: Acme\UserBundle\Entity\User
            rules:
            - {
                event: 'numerique1.notification.event.entity_post_update',  
                route: 'Acme\UserBundle\Controller\UserController::updateUserAction', #Default: '*'
                builder: 'numerique1_notification.default_notification_builder' #The builder which create the notification
                extra:{message: 'Some user has been updated', users: [1,2,3], yourkey: yourdata} #Some extra data you can use to generate your notification
              }

```
