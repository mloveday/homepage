<?php

namespace App\Repository;

use App\Entity\CvInterest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CvInterest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvInterest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvInterest[]    findAll()
 * @method CvInterest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvInterestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CvInterest::class);
    }

    // /**
    //  * @return CvInterest[] Returns an array of CvInterest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CvInterest
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
