<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\MetafieldBase;
use Doctrine\ORM\EntityRepository;

/**
 * @method MetafieldBase|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetafieldBase|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetafieldBase[]    findAll()
 * @method MetafieldBase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetafieldBaseRepository extends EntityRepository
{
}
