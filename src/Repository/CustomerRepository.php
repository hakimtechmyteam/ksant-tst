<?php

namespace App\Repository;

use ApiPlatform\Doctrine\Orm\Paginator;
use App\Entity\Customer;
use App\Repository\Helper\CollectionPaginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly CollectionPaginator $collectionPaginator)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @return Paginator|Customer[] Returns an array of Customer objects
     *
     * @throws QueryException
     */
    public function all(): Paginator|array
    {
        $qb = $this->createQueryBuilder('c');

        return $this->collectionPaginator->getPaginator($qb);
    }
}
