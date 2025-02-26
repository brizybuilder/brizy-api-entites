<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Template;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Common\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TemplateRepository
 */
class TemplateRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Template::class);
    }

}
