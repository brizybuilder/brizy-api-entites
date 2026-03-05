<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SettingsTrait
{
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $settings = [];

    public function getSettings(): array
    {
        return $this->settings ?: [];
    }

    public function setSettings(?array $settings = []): self
    {
        $this->settings = $settings;

        return $this;
    }
}
