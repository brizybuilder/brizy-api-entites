<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Brizy\Bundle\ApiEntitiesBundle\Annotation\GenerateSlug;
use Brizy\Bundle\ApiEntitiesBundle\Annotation\GenerateTitle;
use Brizy\Bundle\ApiEntitiesBundle\Constants\CollectionConst;
use Brizy\Bundle\ApiEntitiesBundle\Constants\ElasticConst;
use Brizy\Bundle\ApiEntitiesBundle\DataSource\Elastic\CollectionItem\CollectionItemCollectionDataProvider as SearchProvider;
use Brizy\Bundle\ApiEntitiesBundle\Dto\CollectionItem\CollectionItemOutput;
use Brizy\Bundle\ApiEntitiesBundle\Dto\CollectionItem\CreateCollectionItemInput;
use Brizy\Bundle\ApiEntitiesBundle\Dto\CollectionItem\UpdateCollectionItemInput;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledHtml;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledScripts;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledStyles;
use Brizy\Bundle\ApiEntitiesBundle\Entity\PageData;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Template;
use Brizy\Bundle\ApiEntitiesBundle\Filter\GraphQL\CollectionItemsFilter;
use Brizy\Bundle\ApiEntitiesBundle\Filter\GraphQL\CollectionItemsOrderFilter;
use Brizy\Bundle\ApiEntitiesBundle\Filter\GraphQL\CollectionTypeFilter;
use Brizy\Bundle\ApiEntitiesBundle\Filter\GraphQL\OffsetFilter;
use Brizy\Bundle\ApiEntitiesBundle\Filter\GraphQL\ReferencedCollectionItemsFilter;
use Brizy\Bundle\ApiEntitiesBundle\Resolver\CollectionItem\CollectionItemBySlugResolver;
use Brizy\Bundle\ApiEntitiesBundle\Resolver\CommonCollectionResolver;
use Brizy\Bundle\ApiEntitiesBundle\Resolver\CommonCreateMutationResolver;
use Brizy\Bundle\ApiEntitiesBundle\Resolver\CommonItemResolver;
use Brizy\Bundle\ApiEntitiesBundle\Resolver\CommonUpdateMutationResolver;
use Brizy\Bundle\ApiEntitiesBundle\Type\Elastic\Definition\Entity\CollectionItemSearchQuery;
use Brizy\Bundle\ApiEntitiesBundle\Validator as AppAssert;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionItemRepository", readOnly=true)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @UniqueConstraint(columns={"project_id","slug"})
 *     },
 *     indexes={
 *          @Index(columns={"project_id", "id",}),
 *          @Index(columns={"project_id", "type_id", "id"}),
 *          @Index(columns={"project_id", "type_id", "title"}),
 *     }
 * )
 */
class CollectionItem
{
    use CommonTraits\IdTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\UpdatedAtTrait;
    use CommonTraits\SEOTrait;
    use CommonTraits\SocialTrait;
    use CommonTraits\AuthorTrait;
    use CommonTraits\PublishDateTrait;
    use CommonTraits\CodeInjectionPropertyTrait;
    use CommonTraits\DependenciesTrait;

    public const SEO_DEFAULT_ENABLE_INDEXING = true;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
      */
    protected $title = '';

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionType", fetch="LAZY")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $slug = '';

    /**
     * @ORM\OneToMany(
     *     targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionItemField",
     *     mappedBy="item",
     *     cascade={"persist", "remove"},
     *     fetch="LAZY"
     * )
     *
     * @MaxDepth(5)
     */
    protected $fields;

    /**
     * @var Template
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @deprecated
     */
    private $template;

    /**
     * @ORM\OneToOne(targetEntity=PageData::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $pageData;

    /**
     * @ORM\OneToOne(targetEntity=CompiledHtml::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledHtml;

    /**
     * @var CompiledScripts
     *
     * @ORM\OneToOne(targetEntity=CompiledScripts::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledScripts;

    /**
     * @var CompiledStyles
     *
     * @ORM\OneToOne(targetEntity=CompiledStyles::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledStyles;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isHomepage = false;

    /**
     * @ORM\Column(type="string", length=50, options={"default": "public"})
     */
    private $visibility = CollectionConst::ITEM_DEFAULT_VISIBILITY_STATUS;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $itemPassword;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->fields = new ArrayCollection();
        $this->status = CollectionConst::ITEM_DEFAULT_STATUS;
        $this->pageData = new PageData();
        $this->compiledScripts = new CompiledScripts();
        $this->compiledStyles = new CompiledStyles();
        $this->compiledHtml = new CompiledHtml();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?CollectionType
    {
        return $this->type;
    }

    public function setType(?CollectionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|CollectionItemField[]
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    /**
     * @param Collection|CollectionItemField[] $fields
     *
     * @return $this
     */
    public function setFields(iterable $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return ?Template
     *
     * @deprecated Use getPageData
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return $this
     *
     * @deprecated Use setPageData
     */
    public function setTemplate($template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): string
    {
        return (string) $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPageData(): ?PageData
    {
        return $this->pageData;
    }

    public function setPageData(PageData $pageData): self
    {
        $this->pageData = $pageData;

        return $this;
    }

    public function getIsHomepage(): bool
    {
        return $this->isHomepage;
    }

    public function setIsHomepage(bool $isHomepage): self
    {
        $this->isHomepage = $isHomepage;

        return $this;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getItemPassword(): ?string
    {
        return $this->itemPassword;
    }

    public function setItemPassword(?string $itemPassword): self
    {
        $this->itemPassword = $itemPassword;

        return $this;
    }

    /**
     * @return mixed
     *
     * @var CompiledHtml
     */
    public function getCompiledHtml()
    {
        return $this->compiledHtml ?? $this->compiledHtml = new CompiledHtml();
    }

    /**
     * @param mixed $compiledHtml
     */
    public function setCompiledHtml(CompiledHtml $compiledHtml): CollectionItem
    {
        $this->compiledHtml = $compiledHtml;

        return $this;
    }

    public function getCompiledScripts(): CompiledScripts
    {
        return $this->compiledScripts ?? $this->compiledScripts = new CompiledScripts();
    }

    /**
     * @param mixed $compiledScripts
     */
    public function setCompiledScripts(CompiledScripts $compiledScripts): CollectionItem
    {
        $this->compiledScripts = $compiledScripts;

        return $this;
    }

    /**
     * @return CompiledStyles
     */
    public function getCompiledStyles()
    {
        return $this->compiledStyles ?? $this->compiledStyles = new CompiledStyles();
    }

    public function setCompiledStyles(CompiledStyles $compiledStyles): CollectionItem
    {
        $this->compiledStyles = $compiledStyles;

        return $this;
    }
}
