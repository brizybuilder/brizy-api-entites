<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;


use Brizy\Bundle\ApiEntitiesBundle\Entity\MetafieldText;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Common\MetafieldValueRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MetafieldText|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetafieldText|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetafieldText[]    findAll()
 * @method MetafieldText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetafieldTextRepository extends MetafieldValueRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MetafieldText::class);
    }

    public function iterateAndReplaceByParents(array $parentIds, callable $callback)
    {
        $metaData = $this->getClassMetadata();
        $tableName = $metaData->getTableName();
        $valueColumn = $metaData->getColumnName('value');
        $entityColumn = $metaData->getColumnName('entity_id');
        $idColumn = $metaData->getColumnName('id');

        $ids = implode(',', $parentIds);
        $parentsSql = "select id from data where parent_id IN ({$ids})";
        $dataIds = $this->_em->getConnection()->executeQuery($parentsSql)->fetchFirstColumn();
        $parentIds = implode(',', array_merge($parentIds, $dataIds));

        $sql = "select id,$entityColumn,$valueColumn from {$tableName} 
                where  {$entityColumn} IN ({$parentIds})";

        $stmt = $this->_em->getConnection()->prepare($sql);
        $result = $stmt->executeQuery();
        $st = $this->_em->getConnection()->prepare("UPDATE {$tableName} SET {$valueColumn} = ? WHERE $idColumn=?");
        while ($row = $result->fetchAssociative()) {
            $str = $callback($row[$valueColumn]);
            if ($str !== $row[$valueColumn]) {
                $st->executeStatement([$str, $row[$idColumn]]);
            }
            unset($row);
        }
        unset($result);
        unset($stmt);
    }
}
