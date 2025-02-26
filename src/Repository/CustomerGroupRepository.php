<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\CustomerGroup;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Common\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CustomerGroupRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerGroup::class);
    }

}
