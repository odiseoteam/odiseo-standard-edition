<?php

namespace App\Entity;

use Odiseo\Bundle\UserBundle\Security\User;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\User\Model\UserOAuthInterface;

class AppUser extends User implements ResourceInterface
{
    /** @var string|null */
    protected $firstName;

    /** @var string|null */
    protected $lastName;
    
    /**
     * @inheritdoc
     */
    public function setEmail(?string $email): void
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }

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
     * @return string
     */
    public function getFullname()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return AppUserOAuth|UserOAuthInterface|null
     */
    public function getFacebook(): ?UserOAuthInterface
    {
        return $this->getOAuthAccount('facebook');
    }

    /**
     * @return AppUserOAuth|UserOAuthInterface|null
     */
    public function getTwitter(): ?UserOAuthInterface
    {
        return $this->getOAuthAccount('twitter');
    }
}