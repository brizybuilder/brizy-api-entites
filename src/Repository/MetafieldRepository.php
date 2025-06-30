<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Metafield;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Metafield|null find($id, $lockMode = null, $lockVersion = null)
 * @method Metafield|null findOneBy(array $criteria, array $orderBy = null)
 * @method Metafield[]    findAll()
 * @method Metafield[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetafieldRepository extends Common\EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Metafield::class);
    }
}
