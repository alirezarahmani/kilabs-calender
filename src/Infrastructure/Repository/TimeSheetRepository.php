<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\UserEntity;
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

    public function removeEmployerUselessBookedTimes(EmployerEntity $entity, \DateTime $date, ?\DateTime $toDate)
    {
        $this->removeIntersectDuration($entity, $date, $toDate);
    }

    public function removeUserUselessBookedTimes(UserEntity $entity, \DateTime $date, ?\DateTime $toDate)
    {
        $this->removeIntersectDuration($entity, $date, $toDate);
    }

    private function removeIntersectDuration(EntityInterface $entity, \DateTime $date, ?\DateTime $toDate)
    {
        $qb = $this->createQueryBuilder('t')->delete('t');
        $qb->Where('t.employer = :employer');

        $operator = '=';
        if (!empty($toDate)) {
            $operator = '>=';
            $qb->andWhere('t.toDate <= :toDate')
               ->setParameter('toDate', $toDate);
        }
            $qb->andWhere('t.date ' . $operator .' :date')
               ->setParameter('date', $date);

            $qb->andWhere('t.employer = :employer')
            ->setParameter('employer', $entity)
            ->getQuery()
            ->getResult();
    }

    public function update(TimeSheetEntity $timeSheet): void
    {
        Assertion::notEmpty($timeSheet->getId(), 'please add set value first,');
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
