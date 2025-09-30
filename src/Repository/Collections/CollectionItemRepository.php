<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItem;
use Doctrine\ORM\EntityRepository;

/**
 * @method CollectionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionItem[]    findAll()
 * @method CollectionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionItemRepository extends EntityRepository {

    /**
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria = []): int
    {
        $qb = $this->createQueryBuilder('ci')
            ->select('COUNT(ci.id)');

        foreach ($criteria as $field => $value) {
            $qb->andWhere('ci.' . $field . ' = :' . $field)
                ->setParameter($field, $value);
        }

        return (int) $qb->getQuery()
            ->getSingleScalarResult();
    }
}