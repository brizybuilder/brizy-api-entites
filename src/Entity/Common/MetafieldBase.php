<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Interfaces\MetaFieldTypeInterface;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Metafield;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

abstract class MetafieldBase implements MetaFieldTypeInterface
{
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Metafield")
     * @ORM\JoinColumn(name="metafield_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $metafield;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer", unique=false)
     */
    protected $entity_id;

    /**
     * @return Metafield
     */
    public function getMetafield(): Metafield
    {
        return $this->metafield;
    }

    /**
     * @param Metafield $metafield
     *
     * @return $this
     */
    public function setMetafield(Metafield $metafield)
    {
        $this->metafield = $metafield;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    /**
     * @param $entity_id
     *
     * @return $this
     */
    public function setEntityId($entity_id): self
    {
        $this->entity_id = $entity_id;

        return $this;
    }
}
