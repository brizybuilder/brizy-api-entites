<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledScripts;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompiledScripts|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompiledScripts|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompiledScripts[]    findAll()
 * @method CompiledScripts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompiledScriptsRepository extends EntityRepository {
}
