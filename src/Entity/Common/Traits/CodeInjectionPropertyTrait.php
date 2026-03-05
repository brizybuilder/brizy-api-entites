<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CodeInjectionPropertyTrait
{
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $codeInjection = [];

    public function getCodeInjection(): ?array
    {
        return $this->codeInjection;
    }

    public function setCodeInjection(?array $codeInjection): self
    {
        $this->codeInjection = $codeInjection;

        return $this;
    }
}
