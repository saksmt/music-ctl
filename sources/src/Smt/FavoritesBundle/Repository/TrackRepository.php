<?php

namespace Smt\FavoritesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Smt\FavoritesBundle\Entity\Track;
use Smt\FavoritesBundle\Parser\OrderParser;

/**
 * Repository of tracks
 * @package Smt\FavoritesBundle\Repository
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class TrackRepository extends EntityRepository
{
    /**
     * Find with paging
     * @param int $page Page number
     * @param int $limit Records per page
     * @param OrderParser $parser Order
     * @return Track[]
     */
    public function findLimited($page, $limit, OrderParser $parser)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->add('orderBy', $parser->getQueryString('t'))
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find unsaved tracks
     * @return Track[]
     */
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
