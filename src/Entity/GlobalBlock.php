<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits as CommonTraits;
use Brizy\Bundle\ApiEntitiesBundle\Repository\GlobalBlockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="global_block")
 * @ORM\Entity(repositoryClass=GlobalBlockRepository::class, readOnly=true)
 */
class GlobalBlock
{
    use CommonTraits\IdTrait;
    use CommonTraits\ProjectTrait;
    use CommonTraits\CreatedAtTrait;
    use CommonTraits\UpdatedAtTrait;
    use CommonTraits\AuthorTrait;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @var PageData
     * @ORM\OneToOne(targetEntity=PageData::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $pageData;

    /**
     * @ORM\Column(type="text")
     */
    private $meta;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tags;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return GlobalBlock
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     *
     * @return GlobalBlock
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return GlobalBlock
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return PageData
     */
    public function getPageData()
    {
        return $this->pageData;
    }

    /**
     * @param mixed $pageData
     *
     * @return GlobalBlock
     */
    public function setPageData($pageData)
    {
        $this->pageData = $pageData;
        $this->pageData->setProject($this->getProject());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param mixed $meta
     *
     * @return GlobalBlock
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): GlobalBlock
    {
        $this->position = $position;

        return $this;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function setTags(string $tags): GlobalBlock
    {
        $this->tags = $tags;

        return $this;
    }
}
