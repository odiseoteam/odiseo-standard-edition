<?php

namespace App\Repository;

use Sylius\Bundle\UserBundle\Doctrine\ORM\UserRepository;

class AppUserRepository extends UserRepository
{
    public function createQueryBuilderByColumn($alias, $column, $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($column)
            ->from($this->_entityName, $alias, $indexBy)
        ;
    }

    public function searchByPlatform($platform)
    {
        if ($platform == 'facebook')
        {
            $andWhere = 'u.facebookId is NOT NULL';
        }else if($platform == 'twitter'){
            $andWhere = 'u.twitterId is NOT NULL';
        }else{
            $andWhere = 'u.facebookId is NULL and u.twitterId is NULL';
        }

        return $this->createQueryBuilder('u')
            ->andWhere($andWhere)
            ->getQuery()
            ->getResult()
        ;
    }
}