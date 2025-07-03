<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionType;
use Doctrine\ORM\EntityRepository;

/**
 * @method CollectionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionType[]    findAll()
 * @method CollectionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionTypeRepository extends EntityRepository {

    /**
     * Find collection types with their fields sorted by field priority.
     *
     * @param array $criteria
     * @return CollectionType[]
     */
    public function findByAndSortFields(array $criteria = []): array
    {
        $qb = $this->createQueryBuilder('ct')
            ->leftJoin('ct.fields', 'f')
            ->addSelect('f')
            ->orderBy('ct.priority', 'DESC')
            ->addOrderBy('ct.id', 'DESC')
            ->addOrderBy('f.priority', 'DESC')
            ->addOrderBy('f.id', 'DESC');

        foreach ($criteria as $field => $value) {
            $qb->andWhere("ct.$field = :$field")
                ->setParameter($field, $value);
        }

        return $qb->getQuery()->getResult();
    }
}