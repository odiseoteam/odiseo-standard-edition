<?php

namespace Odiseo\Bundle\AppBundle\Entity;

use DateTime;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * User
 */
class User extends BaseUser implements ResourceInterface
{
}