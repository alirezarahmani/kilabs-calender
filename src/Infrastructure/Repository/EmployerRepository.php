<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

//according to https://stackoverflow.com/questions/13846209/where-to-define-the-interfaces-for-a-repository-in-an-layered-architecture
use App\Domain\Entity\EmployerEntity;
use App\Domain\Repository\RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EmployerEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployerEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployerEntity[]    findAll()
 * @method EmployerEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployerRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmployerEntity::class);
    }
}
