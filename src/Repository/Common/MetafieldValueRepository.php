<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository\Common;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Metafield;
use Doctrine\Persistence\ManagerRegistry;

abstract class MetafieldValueRepository extends EntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function getMetafieldValue(Metafield $metafield): ?MetafieldBase
    {
        return $this->findOneBy(['metafield' => $metafield]);
    }

    public function findAndRemoveByMetafield($metafield): void
    {
        $metafieldValue = $this->findOneBy(['metafield' => $metafield]);
        if ($metafieldValue) {
            $this->remove($metafieldValue);
        }
    }

    public function getAllByExcluding($projectId, $excludeNames = [])
    {
        $qb = $this->createQueryBuilder('v');
        $qb->join('v.metafield', 'm')
            ->where('v.entity_id=:entity_id')
            ->setParameter('entity_id', (int) $projectId);

        if (count($excludeNames)) {
            $qb->andWhere($qb->expr()->notIn('m.name', $excludeNames));
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * THIS SHOULD NOT BE DONE IN BRIZY API. MTF..
     *
     * This is a low level method.
     * It uses native sql queries to clone the meta fields to save memory.
     *
     * This method is a bit dangerous because it does not do any validations.
     * Use it wisely or better do not to use it at all.
     *
     * @param int $sourceProjectId
     * @param int $targetProjectId
     *
     * @return void
     */
    public function cloneProjectMetaFields($sourceProjectId, $targetProjectId, $excludeNames = [], $callback = null)
    {
        $tableName = $this->_em->getClassMetadata($this->getClassName())->getTableName();

        $sourceMetaFields = $this->getFields($sourceProjectId, $excludeNames);
        $targetMetaFieldIds = array_map(function ($field) {
            return $field['metafield']['id'];
        }, $this->getFields($targetProjectId, $excludeNames));

        $connection = $this->_em->getConnection();

        $stmt = $connection->prepare(
            "INSERT INTO {$tableName} (metafield_id, entity_id, value,created_at,updated_at ) 
                    VALUES(?,?,?,NOW(),NOW())"
        );

        $fieldMap = [];

        foreach ($sourceMetaFields as $field) {
            if (in_array($field['metafield']['id'], $targetMetaFieldIds)) {
                continue;
            }

            if (is_callable($callback)) {
                $field = $callback($field);
            }

            $stmt->executeQuery(
                [
                    $field['metafield']['id'],
                    $targetProjectId,
                    $field['value'],
                ]
            );

            $fieldMap[] = (int) $connection->lastInsertId();
        }

        return $fieldMap;
    }

    /**
     * @param $excludeNames
     *
     * @return array|float|int|string
     */
    protected function getFields(int $sourceProjectId, $excludeNames)
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('v', 'm')
            ->join('v.metafield', 'm')
            ->where('v.entity_id=:entity_id')
            ->setParameter('entity_id', (int) $sourceProjectId);

        if (count($excludeNames)) {
            $qb->andWhere($qb->expr()->notIn('m.name', $excludeNames));
        }

        $metafields = $qb->getQuery()->getArrayResult();

        return $metafields;
    }
}
