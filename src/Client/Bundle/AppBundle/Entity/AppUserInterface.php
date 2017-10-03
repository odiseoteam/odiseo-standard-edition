<?php

namespace Client\Bundle\AppBundle\Entity;

use Odiseo\Bundle\UserBundle\Security\UserInterface;

/**
 * AppUserInterface
 */
interface AppUserInterface extends UserInterface
{
    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $lastName
     */
    public function setLastName($lastName);

    /**
     * @return null|\Sylius\Component\User\Model\UserOAuthInterface
     */
    public function getFacebook();

    /**
     * @return null|\Sylius\Component\User\Model\UserOAuthInterface
     */
    public function getTwitter();
}