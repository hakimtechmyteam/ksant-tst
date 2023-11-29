<?php

namespace App\Repository\Helper;

use ApiPlatform\Doctrine\Orm\Paginator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\HttpFoundation\RequestStack;

class CollectionPaginator
{
    const ITEMS_PER_PAGE = 20;

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * @throws QueryException
     */
    public function getPaginator(QueryBuilder $qb, int $perPage = null): Paginator
    {
        $page = $this->requestStack->getCurrentRequest()->query->getInt('page', 1);
        $itemsPerPage = $perPage ?? self::ITEMS_PER_PAGE;
        $firstResult = ($page - 1) * $itemsPerPage;
        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage);
        $qb->addCriteria($criteria);
        $doctrinePaginator = new DoctrinePaginator($qb);

        return new Paginator($doctrinePaginator);
    }
}
