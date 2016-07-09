<?php

namespace Odiseo\Bundle\AppBundle\DataFixtures\ORM;

use Symfony\Component\Finder\Finder;
use Odiseo\Bundle\AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$userAdmin = new User();
    	$userAdmin->setUsername('admin');
    	$userAdmin->setEmail('admin@odiseo.com.ar');
    	$userAdmin->setPlainPassword('123456');
    	$userAdmin->setEnabled(true);
    	$userAdmin->setRoles(array('ROLE_ADMIN'));
    	 
    	$manager->persist($userAdmin);
    	
    	$manager->flush();
    }
    
    public function getOrder()
    {
    	return 1;
    }
}