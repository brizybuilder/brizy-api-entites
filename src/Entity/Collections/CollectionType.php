<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Annotation\GenerateSlug;
use App\Annotation\GraphQLType;
use App\Constants\ElasticConst;
use App\Constants\GraphQLConst;
use App\Constants\WebhookConst;
use App\Dto\CollectionType\CreateCollectionTypeInput;
use App\Dto\CollectionType\UpdateCollectionTypeInput;
use App\Resolver\CollectionType\CollectionTypeBySlugResolver;
use App\Resolver\CollectionType\CollectionTypeCollectionResolver;
use App\Resolver\CollectionType\CollectionTypeCreateMutationResolver;
use App\Resolver\CollectionType\CollectionTypeResolver;
use App\Resolver\CollectionType\CollectionTypeUpdateMutationResolver;
use App\Type\GraphQL\Definition\CollectionTypeSettingsType;
use App\Validator as AppAssert;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionTypeRepository", readOnly=true)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @UniqueConstraint(columns={"project_id", "id"}),
 *          @UniqueConstraint(columns={"project_id", "title"}),
 *          @UniqueConstraint(columns={"project_id", "slug"}),
 *     },
 *     indexes={
 *          @Index(columns={"project_id", "priority"}),
 *     }
 * )
 * @UniqueEntity(fields={"project", "title"}, errorPath="title")
 * @UniqueEntity(fields={"project", "slug"}, errorPath="slug")
 */
class CollectionType
{
    use CommonTraits\IdTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\PriorityTrait;
    use CommonTraits\TitleTrait;
    use CommonTraits\SettingsTrait;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Collections\CollectionCategory")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     *
     * @Assert\Expression(
     *     "!value or !this.getProject() or value.getProject().getId() == this.getProject().getId()",
     *     message="Invalid category project"
     * )
     */
    protected $category;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Collections\CollectionTypeField",
     *     mappedBy="collectionType",
     *     cascade={"persist", "remove"},
     *     fetch="EAGER"
     * )
     * @ORM\OrderBy({"priority": "DESC"})
     */
    protected $fields;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $settings = [];

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Template", mappedBy="type")
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
    private  $public = self::PUBLIC_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":CollectionType::PUBLIC_DEFAULT_VALUE})
     */
    private  $showUI = self::SHOW_UI_DEFAULT_VALUE;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":CollectionType::PUBLIC_DEFAULT_VALUE})
     */
    private  $showInMenu = self::SHOW_IN_MENU_DEFAULT_VALUE;

    /**
     * CollectionType constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->fields = new ArrayCollection();
        $this->templates = new ArrayCollection();
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
         * @see \App\Type\GraphQL\Definition\CollectionTypeSettingsType::getSettingsFields
         */
        $settings[CollectionTypeSettingsType::FIELD_HIDDEN] = (bool) ($settings[CollectionTypeSettingsType::FIELD_HIDDEN] ?? false);

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
}
