<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function getBySlug(string $slug, bool $includeArchived = false)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('b.id', 'DESC');
        if (!$includeArchived) {
            $qb->andWhere('b.archived = false');
        }
        return $qb->getQuery()->getSingleResult();
    }

    public function getList(bool $includeArchived = false)
    {
        $qb = $this->createQueryBuilder('b');
        if (!$includeArchived) {
            $qb->andWhere('b.archived = false');
        }
        return $qb->getQuery()->getResult();
    }
}
