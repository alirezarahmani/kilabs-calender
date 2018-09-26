<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\RepositoryInterface;
use App\Domain\Entity\TimeSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TimeSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeSheet[]    findAll()
 * @method TimeSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeSheetRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TimeSheet::class);
    }

//    /**
//     * @return TimeSheet[] Returns an array of TimeSheet objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeSheet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
