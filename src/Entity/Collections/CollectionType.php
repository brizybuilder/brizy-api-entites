<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionTypeRepository", readOnly=true)
 */
class CollectionType
{
    use CommonTraits\IdTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\PriorityTrait;
    use CommonTraits\TitleTrait;
    use CommonTraits\SettingsTrait;

    public const DEFAULT_PERMALINK_PATTERN = '/{collectionType.slug}/{slug}';
    public const PUBLIC_DEFAULT_VALUE = true;
    public const SHOW_UI_DEFAULT_VALUE = true;
    public const SHOW_IN_MENU_DEFAULT_VALUE = true;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $slug = '';

    /**
     * @ORM\ManyToOne(targetEntity="CollectionEditor", inversedBy="collectionTypes", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $editor;

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionCategory")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     *
     */
    protected $category;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionTypeField",
     *     mappedBy="collectionType",
     *     cascade={"persist", "remove"},
     *     fetch="EAGER"
     * )
     */
    protected $fields;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $settings = [];

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Template", mappedBy="type")
     */
    private $templates;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    private $hasPreview = true;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":CollectionType::PUBLIC_DEFAULT_VALUE})
     */
    private $public = self::PUBLIC_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":CollectionType::PUBLIC_DEFAULT_VALUE})
     */
    private $showUI = self::SHOW_UI_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":CollectionType::PUBLIC_DEFAULT_VALUE})
     */
    private $showInMenu = self::SHOW_IN_MENU_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $permalinkPattern = self::DEFAULT_PERMALINK_PATTERN;

    /**
     * CollectionType constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->fields = new ArrayCollection();
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

    public function getEditor(): ?CollectionEditor
    {
        return $this->editor;
    }

    public function setEditor(?CollectionEditor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getCategory(): ?CollectionCategory
    {
        return $this->category;
    }

    public function setCategory(?CollectionCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|CollectionTypeField[]
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function setFields(iterable $collection): self
    {
        $this->fields = $collection;

        return $this;
    }

    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    /**
     * @return CollectionType
     */
    public function setTemplates(Collection $templates): self
    {
        $this->templates = $templates;

        foreach ($this->templates as $template) {
            $template->setType($this);
        }

        return $this;
    }

    public function getSettings(): array
    {
        $settings = $this->settings ?: [];

        /*
         * Must be nonNull
         * @see \Brizy\Bundle\ApiEntitiesBundle\Type\GraphQL\Definition\CollectionTypeSettingsType::getSettingsFields
         */
        $settings['hidden'] = (bool) ($settings['hidden'] ?? false);

        return $settings;
    }

    public function getHasPreview(): bool
    {
        return $this->hasPreview;
    }

    public function setHasPreview(bool $hasPreview): self
    {
        $this->hasPreview = $hasPreview;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getShowUI(): ?bool
    {
        return $this->showUI;
    }

    public function setShowUI(bool $showUI): self
    {
        $this->showUI = $showUI;

        return $this;
    }

    public function getShowInMenu(): ?bool
    {
        return $this->showInMenu;
    }

    public function setShowInMenu(bool $showInMenu): self
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    public function getPermalinkPattern(): ?string
    {
        return $this->permalinkPattern;
    }

    public function setPermalinkPattern(?string $permalinkPattern): self
    {
        $this->permalinkPattern = $permalinkPattern;

        return $this;
    }
}
