<?php

namespace App\Repository;

use App\Entity\LogRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogRequest>
 *
 * @method LogRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogRequest[]    findAll()
 * @method LogRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogRequest::class);
    }

    public function save(LogRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LogRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
