<?php

namespace AppBundle\Repository;

use AppBundle\Entity\MusicTodo;
use Doctrine\ORM\EntityRepository;

class MusicTodoRepository extends EntityRepository
{
    /**
     * @param $page
     * @param $limit
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