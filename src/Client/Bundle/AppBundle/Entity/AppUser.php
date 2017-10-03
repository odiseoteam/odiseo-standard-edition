<?php

namespace Client\Bundle\AppBundle\Entity;

use Odiseo\Bundle\UserBundle\Security\User;

/**
 * AppUser
 */
class AppUser extends User implements AppUserInterface
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