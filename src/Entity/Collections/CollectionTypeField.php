<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Constants\CollectionConst;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionTypeFieldRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CollectionTypeFieldRepository::class)]
class CollectionTypeField
{
    use CommonTraits\IdTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\PriorityTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\SettingsTrait;

    public const REQUIRED_DEFAULT_VALUE = false;
    public const HIDDEN_DEFAULT_VALUE = false;
    public const UNIQUE_DEFAULT_VALUE = false;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected $id;

    #[ORM\ManyToOne(targetEntity: CollectionType::class, inversedBy: "fields")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    protected $collectionType;

    #[ORM\Column(type: "string", length: 30)]
    protected $type;

    #[ORM\Column(type: "string", nullable: false)]
    private $slug;

    #[ORM\Column(type: "boolean", options: ["default" => CollectionTypeField::REQUIRED_DEFAULT_VALUE])]
    protected $required = self::REQUIRED_DEFAULT_VALUE;

    #[ORM\Column(type: "boolean", options: ["default" => CollectionTypeField::HIDDEN_DEFAULT_VALUE])]
    protected $hidden = self::HIDDEN_DEFAULT_VALUE;

    #[ORM\Column(name: '`unique`', type: "boolean", options: ["default" => CollectionTypeField::UNIQUE_DEFAULT_VALUE])]
    protected $unique = self::UNIQUE_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    #[ORM\Column(type: "string", length: 120, nullable: false)]
    protected $label;

    #[ORM\Column(type: "text", nullable: true)]
    protected $description;

    #[ORM\Column(type: "string", length: 30, nullable: false, options: ["default" => CollectionConst::FIELD_DEFAULT_PLACEMENT])]
    protected $placement = CollectionConst::FIELD_DEFAULT_PLACEMENT;

    #[ORM\Column(type: "json", nullable: true)]
    protected $settings = [];

    #[ORM\ManyToOne(targetEntity: CollectionType::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    protected $reference;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return CollectionType
     */
    public function getCollectionType()
    {
        return $this->collectionType;
    }

    public function setCollectionType($collectionType): self
    {
        $this->collectionType = $collectionType;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(?bool $required): self
    {
        $this->required = (bool)$required;

        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = (bool)$hidden;

        return $this;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function setUnique(?bool $unique): self
    {
        $this->unique = (bool)$unique;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPlacement(): string
    {
        return $this->placement;
    }

    public function setPlacement(string $placement): self
    {
        $this->placement = $placement;

        return $this;
    }

    public function getReference(): ?CollectionType
    {
        return $this->reference;
    }

    public function setReference(?CollectionType $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
