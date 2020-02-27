<?php

namespace App\Repository;

use App\Entity\CvEducator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CvEducator|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvEducator|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvEducator[]    findAll()
 * @method CvEducator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvEducatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CvEducator::class);
    }

    // /**
    //  * @return CvEducator[] Returns an array of CvEducator objects
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
    public function findOneBySomeField($value): ?CvEducator
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
