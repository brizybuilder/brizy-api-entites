<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;


use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionType;
use Brizy\Bundle\ApiEntitiesBundle\Repository\TemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateRepository::class)]
class Template
{
    use Common\Traits\IdTrait;
    use Common\Traits\ProjectTrait;
    use Common\Traits\TitleTrait;
    use Common\Traits\CreatedAtTrait;

    #[ORM\Column(type: "text", nullable: false)]
    private $data = '{}';

    #[ORM\ManyToOne(targetEntity: CollectionType::class, inversedBy: "templates")]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
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
