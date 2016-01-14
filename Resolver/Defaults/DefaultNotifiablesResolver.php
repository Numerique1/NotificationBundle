<?php
namespace Numerique1\Bundle\NotificationBundle\Resolver\Defaults\Resolver;

use Numerique1\Bundle\NotificationBundle\Model\NotifiableInterface;
use Numerique1\Bundle\NotificationBundle\Resolver\NotifiablesResolverInterface;
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
     * @param array $parameters
     * @return array
     */
    public function resolve($entity, $parameters = array())
    {
        $return = array();
        if ($entity instanceof NotifiableInterface)
        {
            foreach ($entity->getNotifiables() as $notifiable)
            {
                $return[] = $notifiable;
            }
        }

        return $return;
    }
}