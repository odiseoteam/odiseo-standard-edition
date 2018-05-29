<?php

namespace App\Repository;

use Sylius\Bundle\UserBundle\Doctrine\ORM\UserRepository;

class AppUserRepository extends UserRepository
{
    /**
     * {@inheritdoc}
     */
    public function findOneByDni($dni)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.dni = :dni')
            ->setParameter('dni', $dni)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findWithoutWinners($winnersIds)
    {
        $qb = $this->createQueryBuilderByColumn('u', 'u.id');

        if(count($winnersIds) > 0)
        {
            $qb
                ->where($qb->expr()->notIn('u.id', $winnersIds))
            ;
        }

        return $qb
            ->getQuery()
            ->getScalarResult()
        ;
    }

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