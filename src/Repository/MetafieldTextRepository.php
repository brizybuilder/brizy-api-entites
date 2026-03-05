<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\MetafieldText;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Common\MetafieldValueRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MetafieldText|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetafieldText|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetafieldText[]    findAll()
 * @method MetafieldText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetafieldTextRepository extends MetafieldValueRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetafieldText::class);
    }
}
