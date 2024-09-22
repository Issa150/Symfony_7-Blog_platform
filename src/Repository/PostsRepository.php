<?php

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Posts>
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    //    /**
    //     * @return Posts[] Returns an array of Posts objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Posts
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findTutorials(int $limit = 5): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.contentTypeId', 'ct')
            ->where('ct.title = :title')
            ->setParameter('title', 'tutorials')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findLists(int $limit = 5): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.contentTypeId', 'ct')
            ->where('ct.title = :title')
            ->setParameter('title', 'lists')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    ////******* user based posts:
    public function findUserTutorials(int $limit = 5, int $userId): array
{
    return $this->createQueryBuilder('p')
        ->join('p.contentTypeId', 'ct')
        ->where('ct.title = :title AND p.userId = :userId')
        ->setParameter('title', 'tutorials')
        ->setParameter('userId', $userId)
        ->orderBy('p.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function findUserLists(int $limit = 5, int $userId): array
{
    return $this->createQueryBuilder('p')
        ->join('p.contentTypeId', 'ct')
        ->where('ct.title = :title AND p.userId = :userId')
        ->setParameter('title', 'lists')
        ->setParameter('userId', $userId)
        ->orderBy('p.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}
}
