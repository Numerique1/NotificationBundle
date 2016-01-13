<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver;

use Numerique1\Bundle\NotificationBundle\Entity\NotifiableInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class DefaultNotifiablesResolver implements NotifiablesResolverInterface
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param $entity
     * @return array
     */
    public function resolve($entity, $parameters = array())
    {
        $return = array();
        if($entity instanceof NotifiableInterface)
        {
            foreach($entity->getNotifiables() as $notifiable)
            {
                    $return[] = $notifiable;
            }
        }
        return $return;
    }
}