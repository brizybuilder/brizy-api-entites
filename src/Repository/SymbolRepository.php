<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Repository\Common\VersionableEntityRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class SymbolRepository extends EntityRepository implements VersionableEntityRepositoryInterface
{
    public function getEntityVersion(object $entity, string $property): int
    {
        return (int) $this->createQueryBuilder('s')
                         ->select("s.{$property}")
                         ->where('s.id=:id')
                         ->setParameter('id', $entity->getId())
                         ->getQuery()
                         ->getSingleScalarResult();
    }
}
