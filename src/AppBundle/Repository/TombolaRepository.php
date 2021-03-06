<?php

namespace AppBundle\Repository;

/**
 * TombolaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TombolaRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByCode($code)
    {
        return $this->createQueryBuilder('t')
                    ->where('t.code LIKE :code')
                    ->setParameter('code', '%'.$code.'%')
                    ->getQuery()->getResult()
            ;
    }
}
