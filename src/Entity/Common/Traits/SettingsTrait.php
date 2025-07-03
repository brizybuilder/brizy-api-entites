<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SettingsTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $settings = '';

    public function getSettings(): array
    {
        return json_decode($this->settings, true) ?: [];
    }

    public function setSettings(array $settings = []): self
    {
        $this->settings = json_encode($settings);

        return $this;
    }
}
