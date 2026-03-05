<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionTypeField;
use Doctrine\ORM\EntityRepository;

/**
 * @method CollectionTypeField|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionTypeField|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionTypeField[]    findAll()
 * @method CollectionTypeField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionTypeFieldRepository extends EntityRepository
{
}
