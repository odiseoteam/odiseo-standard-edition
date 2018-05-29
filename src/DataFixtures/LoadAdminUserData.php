<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Odiseo\Bundle\AdminBundle\Entity\AdminUser;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAdminUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$adminUser = new AdminUser();
        $adminUser->setUsername('admin');
        $adminUser->setEmail('admin@odiseo.com.ar');
        $adminUser->setPlainPassword('123456');
        $adminUser->setEnabled(true);
        $adminUser->addRole('ROLE_ADMIN');
    	 
    	$manager->persist($adminUser);
    	
    	$manager->flush();
    }
    
    public function getOrder()
    {
    	return 1;
    }
}