<?php

namespace Client\Bundle\AdminBundle\DataFixtures\ORM;

use Odiseo\Bundle\AdminBundle\Entity\AdminUser;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;

class LoadAdminUserData extends ContainerAwareFixture implements OrderedFixtureInterface
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