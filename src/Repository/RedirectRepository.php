<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RedirectRepository extends EntityRepository
{
    public function getAllAssociative(int $projectId): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.path, r.target')
            ->where('r.project = :project')
            ->setParameter('project', $projectId)
            ->getQuery()
            ->getArrayResult();
    }

    public function getAllPaths(int $projectId): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.path')
            ->where('r.project = :project')
            ->setParameter('project', $projectId)
            ->getQuery()
            ->getArrayResult();
    }
}
