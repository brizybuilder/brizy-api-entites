<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GlobalBlockRepository extends EntityRepository
{
    public function findIdsBy(array $criteria, array $orderBy = null)
    {
        $queryBuilder = $this->createQueryBuilder('g');
        $queryBuilder->select('g.id');

        $expr = $queryBuilder->expr()->andX();
        if (count($criteria)) {
            foreach ($criteria as $field => $value) {
                $expr->add($queryBuilder->expr()->eq($field, $queryBuilder->expr()->literal($value)));
            }
        }

        if (is_array($orderBy)) {
            $field = array_keys($orderBy);
            $sort = array_values($orderBy);

            if (isset($field[0]) && isset($sort[0])) {
                $queryBuilder->orderBy('g.'.$field[0], $sort[0]);
            }
        }

        return $queryBuilder->getQuery()->getScalarResult();
    }
}
