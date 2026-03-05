<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SocialTrait
{
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $social = [];

    public function getSocial(): array
    {
        return $this->social ?? [];
    }

    public function setSocial(?array $social): self
    {
        $this->social = $social ?? [];

        return $this;
    }
}
