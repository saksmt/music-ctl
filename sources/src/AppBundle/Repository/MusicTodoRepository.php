<?php

namespace AppBundle\Repository;

use AppBundle\Entity\MusicTodo;
use Doctrine\ORM\EntityRepository;

/**
 * Repository for to \bdo
 * @package AppBundle\Repository
 * @author Kirill Saksin <kirillsaksin@yandex.ru>
 */
class MusicTodoRepository extends EntityRepository
{
    /**
     * @param int $page Page number
     * @param int $limit Records limit per page
     * @return MusicTodo[]
     */
    public function findLimited($page, $limit)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page - 1))
            ->getQuery()
            ->getResult()
        ;
    }
}
