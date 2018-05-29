<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new AppUser();
        $user->setUsername('user1');
        $user->setEmail('user1@odiseo.com.ar');
        $user->setPlainPassword('123456');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');

        $manager->persist($user);

        $manager->flush();
    }
    
    public function getOrder()
    {
    	return 2;
    }
}