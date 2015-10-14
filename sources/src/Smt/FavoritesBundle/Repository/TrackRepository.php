<?php

namespace Smt\FavoritesBundle\Repository;

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
            ->addOrderBy('t.artist')
            ->addOrderBy('t.album')
            ->addOrderBy('t.title')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUnsaved()
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.saved = 0')
            ->orderBy('t.rating', 'DESC')
            ->addOrderBy('t.artist')
            ->addOrderBy('t.album')
            ->addOrderBy('t.title')
            ->getQuery()
            ->getResult()
        ;
    }
}