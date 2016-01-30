# NotificationBundle

## Information

The bundle provides a facility to generate notifications (email, database, flash) in Symfony projects.

## How to use
  - Step 1 : Create an entity which extends our Notification model (might be optionnal)
  - Step 2 : Create factory class which implements NotificationFactoryInterface which will create Notification
  - Step 3 : Create some notification rules (see: "Configuration Reference")

### Step 1 : 
Create an entity which extends our Notification model (might be optionnal)
```php
<?php

namespace Acme\NotificationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Numerique1\Bundle\NotificationBundle\Model\Notification as BaseNotification;

/**
 * @ORM\Entity()
 * @ORM\Table(name="acme_notification")
 */
class Notification extends BaseNotification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

      /**
     * @ManyToMany(targetEntity="User")
     * @JoinTable(name="notifications_users",
     *      joinColumns={@JoinColumn(name="notification_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $users;

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
}
```
### Step 2 : 
Create factory class which implements NotificationFactoryInterface which will create Notification
```php
<?php
namespace Acme\NotificationBundle\Factory;

use Numerique1\Bundle\NotificationBundle\Event\NotificationEvent;
use Numerique1\Bundle\NotificationBundle\Event\PreUpdateNotificationEvent;
use Numerique1\Bundle\NotificationBundle\Factory\NotificationFactoryInterface;
use Numerique1\Bundle\NotificationBundle\Resolver\Container\NotifiablesResolverContainer;
use Numerique1\Bundle\NotificationBundle\Resolver\Container\TemplateResolverContainer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class NotificationFactory implements NotificationFactoryInterface
{
    private $nrc;
    private $trc;
    private $em;
    private $twig;
    private $translator;

    public function __construct(NotifiablesResolverContainer $nrc, TemplateResolverContainer $trc, EntityManager $em, EngineInterface $twig, $translator)
    {
        $this->nrc = $nrc;
        $this->trc = $trc;
        $this->em = $em;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * @param NotificationEvent $event
     * @param array $rule
     */
    public function create(NotificationEvent $event, array $rule)
    {
        $entity = $event->getEntity();
        $parameters = $event->getParameters();
        $templateResolver = $this->trc->getResolver($rule['template_resolver']);
        $template = $templateResolver->resolve($entity, $rule);

        if($template)
        {
            $content = $this->twig->render($template, array(
                'entity' => $entity,
                'parameters' => $parameters
            ));

            /*Resolver users to notify*/
            $resolver = $this->nrc->getResolver($rule['resolver']);
            $users = $resolver->resolve($entity, array('someOptionnalData' => 'data'));
            
            $notification
                ->setTargetClass(ClassUtils::getClass($entity))
                ->setTargetId($entity->getId())
                ->setContent($content)
                ->setUsers($users)
            ;
            
            $this->em->persist($notification);
            $this->em->flush();
        }
    }
}
```
## Configuration Reference

```php
numerique1_notification:
    factory_class: Acme\NotificationBundle\Factory\NotificationFactory
    notification_class: Acme\NotificationBundle\Entity\Notification
    notifications:
        acme:
            class: Acme\UserBundle\Entity\User
            rules:
            - {
                event: 'numerique1.notification.event.entity_post_update',  
                route: 'Acme\UserBundle\Controller\UserController::updateUserAction', #Default: '*'
                template: 'AcmeUserBundle:Notification:update.html.twig', #Default: false
                template_resolver: 'numerique1_notification.default_template_resolver' #Default / resolve template
                resolver: 'numerique1_notification.default_users_resolver' #Default / resolve users which will be notify
              }

```
