<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\RepositoryInterface;
use App\Domain\Entity\TimeSheetEntity;
use Assert\Assertion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TimeSheetEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeSheetEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeSheetEntity[]    findAll()
 * @method TimeSheetEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeSheetRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TimeSheetEntity::class);
    }

    public function update(TimeSheetEntity $timeSheet)
    {
        Assertion::notEmpty($timeSheet->getId(), 'please add some value to TimeSheet');
        $this->_em->persist($timeSheet);
        $this->_em->flush($timeSheet);
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
