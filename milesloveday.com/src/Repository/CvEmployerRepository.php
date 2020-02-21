<?php

namespace App\Repository;

use App\Entity\CvEmployer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CvEmployer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvEmployer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvEmployer[]    findAll()
 * @method CvEmployer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvEmployerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CvEmployer::class);
    }

    // /**
    //  * @return CvEmployer[] Returns an array of CvEmployer objects
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
    public function findOneBySomeField($value): ?CvEmployer
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
