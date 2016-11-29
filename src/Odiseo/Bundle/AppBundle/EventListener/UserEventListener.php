<?php

namespace Odiseo\Bundle\AppBundle\EventListener;

use FOS\UserBundle\Model\UserManagerInterface;
use Odiseo\Bundle\AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;

class UserEventListener
{
    use ContainerAwareTrait;

    public function onUserUpdate(GenericEvent $event)
    {
        $user = $event->getSubject();

        if ($user instanceof User)
        {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->container->get('fos_user.user_manager');

            $userManager->updateUser($user);
        }
    }
}