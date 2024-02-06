<?php

namespace App\Repository;

use App\Entity\UserItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserItem>
 *
 * @method UserItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserItem[]    findAll()
 * @method UserItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserItem::class);
    }

//    /**
//     * @return UserItem[] Returns an array of UserItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserItem
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
