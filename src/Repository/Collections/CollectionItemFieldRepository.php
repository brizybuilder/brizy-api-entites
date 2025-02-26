<?php

declare(strict_types=1);
namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItem;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItemField;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionTypeField;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionItemField|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionItemField|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionItemField[]    findAll()
 * @method CollectionItemField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionItemFieldRepository extends EntityRepository {
}
