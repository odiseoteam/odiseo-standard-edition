<?php

namespace App\Entity;

use Odiseo\Bundle\UserBundle\Security\User;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * AppUser
 */
class AppUser extends User implements ResourceInterface
{
    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return AppUserOAuth|UserOAuthInterface|null
     */
    public function getFacebook()
    {
        return $this->getOAuthAccount('facebook');
    }

    /**
     * @return AppUserOAuth|UserOAuthInterface|null
     */
    public function getTwitter(): AppUserOAuth
    {
        return $this->getOAuthAccount('twitter');
    }
}