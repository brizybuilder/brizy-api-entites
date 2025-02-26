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
}