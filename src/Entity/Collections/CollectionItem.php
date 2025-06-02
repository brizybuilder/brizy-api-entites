<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Collections;


use Brizy\Bundle\ApiEntitiesBundle\Constants\CollectionConst;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\AuthorTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CodeInjectionPropertyTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\DependenciesTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\PublishDateTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\SEOTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\SocialTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\UpdatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledData;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledHtml;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledScripts;
use Brizy\Bundle\ApiEntitiesBundle\Entity\CompiledStyles;
use Brizy\Bundle\ApiEntitiesBundle\Entity\PageData;
use Brizy\Bundle\ApiEntitiesBundle\Repository\Collections\CollectionItemRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CollectionItemRepository::class, readOnly: true)]
class CollectionItem
{
    use IdTrait;
    use ProjectTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use SEOTrait;
    use SocialTrait;
    use AuthorTrait;
    use PublishDateTrait;
    use CodeInjectionPropertyTrait;
    use DependenciesTrait;

    public const SEO_DEFAULT_ENABLE_INDEXING = true;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected $id;

    #[ORM\Column(type: "string", length: 120, nullable: false)]
    protected $title = '';

    #[ORM\Column(type: "string", length: 20)]
    protected $status;

    #[ORM\ManyToOne(targetEntity: CollectionType::class, fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    protected $type;

    #[ORM\Column(type: "string", nullable: false)]
    protected $slug = '';

    #[ORM\OneToMany(
        targetEntity: CollectionItemField::class,
        mappedBy: "item",
        cascade: ["persist", "remove"],
        fetch: "LAZY"
    )]
    protected $fields;

    #[ORM\Column(type: "integer", nullable: true)]
    private $template;

    #[ORM\OneToOne(targetEntity: PageData::class, cascade: ["persist", "remove"], fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: true, referencedColumnName: "id", onDelete: "SET NULL")]
    private $pageData;

    #[ORM\OneToOne(targetEntity: CompiledData::class, cascade: ["persist", "remove"], fetch: "LAZY")]
    #[ORM\JoinColumn(nullable: true, referencedColumnName: "id", onDelete: "SET NULL")]
    private CompiledData $compiledData;

    #[ORM\Column(type: "boolean", options: ["default" => 0])]
    private $isHomepage = false;

    #[ORM\Column(type: "string", length: 50, options: ["default" => "public"])]
    private $visibility = CollectionConst::ITEM_DEFAULT_VISIBILITY_STATUS;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $itemPassword;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->fields = new ArrayCollection();
        $this->status = CollectionConst::ITEM_DEFAULT_STATUS;
        $this->pageData = new PageData();
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
        return (string)$this->title;
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

    public function getCompiledData(): CompiledData
    {
        return $this->compiledData ?? $this->compiledData = new CompiledData();
    }

    /**
     * @return $this
     */
    public function setCompiledData(CompiledData $compiledData): CollectionItem
    {
        $this->compiledData = $compiledData;

        return $this;
    }
}
