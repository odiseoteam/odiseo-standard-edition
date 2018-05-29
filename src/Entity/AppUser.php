<?php

namespace App\Entity;

use Odiseo\Bundle\UserBundle\Security\User;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * AppUser
 */
class AppUser extends User implements ResourceInterface
{
    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /**
     * @inheritdoc
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @inheritdoc
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @inheritdoc
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @inheritdoc
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @inheritdoc
     */
    public function getFacebook()
    {
        return $this->getOAuthAccount('facebook');
    }

    /**
     * @inheritdoc
     */
    public function getTwitter()
    {
        return $this->getOAuthAccount('twitter');
    }
}