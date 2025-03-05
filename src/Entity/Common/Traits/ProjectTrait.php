<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ProjectTrait
{
    #[ORM\Column(type: "integer", nullable: false, name: 'project_id')]
    protected $project;

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(?int $project): self
    {
        $this->project = $project;

        return $this;
    }
}
