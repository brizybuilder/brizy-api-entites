<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Repository\SymbolDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SymbolDataRepository::class, readOnly=true)
 */
class SymbolData
{
    use IdTrait;
    use ProjectTrait;

    /**
     * @ORM\Column(type="text")
     */
    private $data;

    public function __construct($data = null)
    {
        $this->setData($data);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }
}
