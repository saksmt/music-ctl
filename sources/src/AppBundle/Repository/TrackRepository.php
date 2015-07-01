<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TrackRepository extends EntityRepository
{
    public function findLimited($page, $limit)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->orderBy('t.rating', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUnsaved()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.saved = 1')
            ->orderBy('t.rating', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}