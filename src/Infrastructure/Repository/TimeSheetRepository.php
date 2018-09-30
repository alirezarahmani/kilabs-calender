<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

//according to https://stackoverflow.com/questions/13846209/where-to-define-the-interfaces-for-a-repository-in-an-layered-architecture
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Entity\EmployerEntity;
use App\Domain\Entity\EntityInterface;
use App\Domain\Entity\UserEntity;
use App\Domain\Repository\RepositoryInterface;
use App\Domain\Entity\TimeSheetEntity;
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

    public function removeIntersectDuration(EntityInterface $entity, \DateTime $date, ?\DateTime $toDate)
    {
        $qb = $this->createQueryBuilder('t');


        $qb->Where('t.employer = :employer');

        $operator = '=';
        if (!empty($toDate)) {
            $operator = '>=';
            $qb->andWhere('t.toDate <= :toDate')
               ->setParameter('toDate', $toDate);
        }
            $qb->andWhere('t.date ' . $operator .' :date')
               ->setParameter('date', $date);

        if (is_a($entity, EmployerEntity::class)) {
            $qb->andWhere('t.employer = :employer')
                ->setParameter('employer', $entity);
        } elseif (is_a($entity, UserEntity::class)) {
            $qb->andWhere('t.user = :user')
                ->setParameter('user', $entity);
        }
        $qb->delete('t');
    }

    public function update(TimeSheetEntity $timeSheet): void
    {
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
