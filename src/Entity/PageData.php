<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Repository\PageDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageDataRepository::class, readOnly=true)
 */
class PageData
{
    use IdTrait;
    use ProjectTrait;

    public const DEFAULT_DATA = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data = self::DEFAULT_DATA;

    public function __construct(?string $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
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
