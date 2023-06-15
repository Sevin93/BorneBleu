<?php

namespace App\Repository;

use App\Entity\Bornes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bornes>
 *
 * @method Bornes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bornes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bornes[]    findAll()
 * @method Bornes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BornesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bornes::class);
    }

    public function save(Bornes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bornes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByIdsNotIn(array $ids)
    {
        if(empty($ids)){
            return $this->findAll()[0];
        }

        return $this->createQueryBuilder('b')
            ->where($this->createQueryBuilder('b')->expr()->notIn('b.id', ':ids'))
            ->setParameter('ids', $ids)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findBornesNotIn(array $ids)
    {
        
        return $this->createQueryBuilder('b')
            ->where($this->createQueryBuilder('b')->expr()->notIn('b.id', ':ids'))
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Bornes[] Returns an array of Bornes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Bornes
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
