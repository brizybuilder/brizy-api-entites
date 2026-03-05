<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Common;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\QueryBuilder;

trait SlugAbleEntity
{
    /**
     * @param $groupId
     */
    public function getSimilarSlugs(string $slugString, string $slugProperty, string $groupProperty, $groupId, $excludeId = null): array
    {
        /**
         * @var QueryBuilder $qb;
         */
        $qb = $this->createQueryBuilder('s');
        $qb->select("s.{$slugProperty}")
           ->where($qb->expr()->like("s.{$slugProperty}", ':slug'))
           ->andWhere("s.{$groupProperty}=:group")
           ->setParameters(new ArrayCollection([
               new Parameter('slug', "{$slugString}%"),
               new Parameter('group', $groupId),
           ]));

        if ($excludeId) {
            $qb->andWhere('s.id <> :id')
                ->setParameter('id', (int) $excludeId);
        }

        $query = $qb->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY);
        $result = $query->getArrayResult();

        return array_column($result, 'slug');
    }
}
