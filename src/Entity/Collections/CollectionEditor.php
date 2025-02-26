<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionEditorRepository", readOnly=true)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @UniqueConstraint(columns={"project_id", "title"})
 *     }
 * )
 * @UniqueEntity(fields={"project", "title"}, errorPath="title")
 */
class CollectionEditor
{
    use CommonTraits\IdTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\TitleTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $url;

    /**
     * @var CollectionType[]
     * @ORM\OneToMany(targetEntity="Brizy\Bundle\ApiEntitiesBundle\RepositoryEntity\Collections\CollectionType", mappedBy="editor", fetch="LAZY")
     */
    protected $collectionTypes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hidden = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->collectionTypes = new ArrayCollection();
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCollectionTypes(): Collection
    {
        return $this->collectionTypes;
    }

    public function setCollectionTypes(Collection $collectionTypes): self
    {
        $this->collectionTypes = $collectionTypes;

        foreach ($this->collectionTypes as $collectionType) {
            $collectionType->setEditor($this);
        }

        return $this;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }
}
