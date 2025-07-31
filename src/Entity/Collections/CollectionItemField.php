<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;


use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionItemFieldRepository", readOnly=true)
 */
class CollectionItemField
{
    use CommonTraits\IdTrait;
    use CommonTraits\ProjectTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItem", inversedBy="fields")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $item;

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionTypeField", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $type;

    /**
     * // name="`values`" because of conflict with "INSERT ... VALUES ..." // https://stackoverflow.com/a/11278568
     * @ORM\Column(name="`values`", type="text", nullable=true)
     */
    protected $values = '';

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItem")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $reference;

    /**
     * @ORM\ManyToMany(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItem")
     * @ORM\JoinTable(name="collection_item_field_multi_reference")
     */
    protected $multiReference;

    public function __construct()
    {
        $this->multiReference = new ArrayCollection();
    }

    /**
     * @return Collection|CollectionItem[]
     */
    public function getMultiReference(): Collection
    {
        return $this->multiReference;
    }

    public function setMultiReference(Collection $multiReference): self
    {
        $this->multiReference = $multiReference;

        return $this;
    }

    public function getItem(): CollectionItem
    {
        return $this->item;
    }

    public function setItem(?CollectionItem $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getType(): ?CollectionTypeField
    {
        return $this->type;
    }

    public function setType(?CollectionTypeField $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValues(): array
    {
        return json_decode($this->values, true) ?: [];
    }

    public function setValues(array $values = []): self
    {
        $this->values = json_encode($values);

        return $this;
    }

    public function getReference(): ?CollectionItem
    {
        return $this->reference;
    }

    public function setReference(?CollectionItem $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
