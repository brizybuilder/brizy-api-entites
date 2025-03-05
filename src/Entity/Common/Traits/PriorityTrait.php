<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PriorityTrait
{
    #[ORM\Column(type: "integer", nullable: false)]
    protected $priority = 0;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority ?? 0;

        return $this;
    }
}
