<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionCategory[]    findAll()
 * @method CollectionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionCategoryRepository extends EntityRepository
{

}
