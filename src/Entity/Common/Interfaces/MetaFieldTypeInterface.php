<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Interfaces;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Metafield;

interface MetaFieldTypeInterface
{
    public function getId(): ?int;

    public function getMetafield(): Metafield;

    public function setMetafield(Metafield $metafield);

    public function getEntityId(): ?int;

    public function setEntityId(int $entity_id): self;

    public function setValue($value);

    public function getValue();
}
