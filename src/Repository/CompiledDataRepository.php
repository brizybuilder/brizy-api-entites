<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Repository;

use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledData;
use Doctrine\Persistence\ManagerRegistry;

class CompiledDataRepository extends Common\EntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompiledData::class);
    }

    public function iterateAndReplaceByParents($parentIds, callable $callback): void
    {
        $parentIds = implode(',', $parentIds);
        $metaData = $this->getClassMetadata();
        $tableName = $metaData->getTableName();
        $bodyColumn = $metaData->getColumnName('html');
        $idColumn = $metaData->getColumnName('id');
        $associationMappings = $metaData->getAssociationMappings();
        $parentColumn = $associationMappings['project']['joinColumns'][0]['name'];

        $batchSize = 20;
        $offset = 0;

        while (true) {
            $sql = "select $idColumn,$bodyColumn from {$tableName} where {$parentColumn} IN ({$parentIds}) and {$bodyColumn} <> '' LIMIT {$batchSize} OFFSET {$offset}";
            $stmt = $this->_em->getConnection()->executeQuery($sql);
            $rows = $stmt->fetchAllAssociative();

            if (empty($rows)) {
                break;
            }

            $st = $this->_em->getConnection()->prepare("UPDATE {$tableName} SET {$bodyColumn} = ? WHERE $idColumn=?");
            foreach ($rows as $row) {
                $str = $callback($row[$bodyColumn]);
                if ($str !== $row[$bodyColumn]) {
                    $st->executeStatement([$str, $row[$idColumn]]);
                }
                unset($row);
            }

            $offset += $batchSize;
            unset($rows);
            unset($row);
        }
    }
}
