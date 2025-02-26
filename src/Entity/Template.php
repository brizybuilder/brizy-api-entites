<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionType;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\TitleTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Brizy\Bundle\ApiEntitiesBundle\Repository\TemplateRepository;

/**
 * @ORM\Entity(repositoryClass=TemplateRepository::class)
 */
class Template
{
    use IdTrait;
    use ProjectTrait;
    use TitleTrait;
    use CreatedAtTrait;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(name="data", type="text", nullable=false)
     */
    private $data = '{}';

    /**
     * @var CollectionType
     *
     * @ORM\ManyToOne(targetEntity=CollectionType::class, inversedBy="templates")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $type;

    /**
     * Template constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return string
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public function setData($data): Template
    {
        $this->data = $data;

        return $this;
    }

    public function getType(): ?CollectionType
    {
        return $this->type;
    }

    public function setType(?CollectionType $type): Template
    {
        $this->type = $type;

        return $this;
    }
}
