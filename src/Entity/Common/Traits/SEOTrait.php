<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SEOTrait
{
     #[ORM\Column(type: "json", nullable: true)]
    protected $seo = [];

    public function getSeo(): array
    {
        return $this->seo ?? [];
    }

    public function setSeo(?array $seo): self
    {
        $this->seo = $seo ?? [];

        return $this;
    }
}
