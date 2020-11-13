<?php

namespace App\Repository;

use App\Entity\PackageInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackageInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageInfo[]    findAll()
 * @method PackageInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackageInfo::class);
    }

    // /**
    //  * @return PackageInfo[] Returns an array of PackageInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PackageInfo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
