<?php

namespace Client\Bundle\AppBundle\EventListener;

use Client\Bundle\AppBundle\Entity\AppUser;
use Sylius\Bundle\UserBundle\Security\UserLoginInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class UserRegistrationListener
{
    /**
     * @var UserLoginInterface
     */
    private $userLogin;

    /**
     * @var string
     */
    private $firewallContextName;

    /**
     * @param UserLoginInterface $userLogin
     * @param string $firewallContextName
     */
    public function __construct(
        UserLoginInterface $userLogin,
        $firewallContextName
    ) {
        $this->userLogin = $userLogin;
        $this->firewallContextName = $firewallContextName;

    }

    /**
     * @param GenericEvent $event
     */
    public function handleUserVerification(GenericEvent $event): void
    {
        $appUser = $event->getSubject();

        Assert::isInstanceOf($appUser, AppUser::class);
        Assert::notNull($appUser);

        $this->enableAndLogin($appUser);

        return;
    }

    /**
     * @param AppUser $appUser
     */
    private function enableAndLogin(AppUser $appUser): void
    {
        $appUser->setEnabled(true);

        $this->userLogin->login($appUser, $this->firewallContextName);
    }
}