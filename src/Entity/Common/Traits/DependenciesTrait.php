<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DependenciesTrait
{
     #[ORM\Column(type: "simple_array", nullable: true)]
    protected  $dependencies = null;

    public function getDependencies()
    {
        return empty($this->dependencies) ? null : $this->dependencies;
    }

    public function setDependencies($dependencies): self
    {
        if (is_array($dependencies)) {
            $this->dependencies = $dependencies;
        }

        return $this;
    }
}
