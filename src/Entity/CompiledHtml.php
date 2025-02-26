<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="Brizy\Bundle\ApiEntitiesBundle\Repository\CompiledHtmlRepository", readOnly=true)
 */
class CompiledHtml
{
    use IdTrait;
    use ProjectTrait;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data = '';

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
