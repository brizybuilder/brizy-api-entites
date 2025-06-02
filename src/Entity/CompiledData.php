<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Doctrine\ORM\Mapping as ORM;
use Brizy\Bundle\ApiEntitiesBundle\Repository\CompiledDataRepository;

#[ORM\Entity(repositoryClass: CompiledDataRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CompiledData
{
    use IdTrait;
    use ProjectTrait;

    /**
     * @ORM\Column(type="text")
     */
    private  $html = '';

    /**
     * @ORM\Column(type="text")
     */
    private  $styles = '';

    /**
     * @ORM\Column(type="text")
     */
    private  $scripts = '';

    /**
     * @ORM\Column(type="integer")
     */
    private  $ttl;

    public function getHtml(): string
    {
        return $this->html;
    }

    public function setHtml(string $html): CompiledData
    {
        $this->html = $html;

        return $this;
    }

    public function getStyles(): string
    {
        return $this->styles;
    }

    public function setStyles(string $styles): CompiledData
    {
        $this->styles = $styles;

        return $this;
    }

    public function getScripts(): string
    {
        return $this->scripts;
    }

    public function setScripts(string $scripts): CompiledData
    {
        $this->scripts = $scripts;

        return $this;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function setTtl(int $ttl): CompiledData
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Set TTL to 90 days from now before persisting
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTtl(): void
    {
        $this->ttl = time() + 7776000;  // 3 * 30 * 24 * 60 * 60
    }
}
