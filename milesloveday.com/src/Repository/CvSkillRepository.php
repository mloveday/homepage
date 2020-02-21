<?php

namespace App\Repository;

use App\Entity\CvSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CvSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method CvSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method CvSkill[]    findAll()
 * @method CvSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CvSkillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CvSkill::class);
    }

    // /**
    //  * @return CvSkill[] Returns an array of CvSkill objects
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
    public function findOneBySomeField($value): ?CvSkill
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
