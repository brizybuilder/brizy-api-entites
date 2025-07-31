<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Doctrine\ORM\Mapping as ORM;
use Brizy\Bundle\ApiEntitiesBundle\Repository\CompiledDataRepository;

/**
 * @ORM\Entity(repositoryClass=CompiledDataRepository::class, readOnly=true)
 */
class CompiledData
{
    use IdTrait;
    use ProjectTrait;

    /**
     * @ORM\Column(type="text", options={"collation"="utf8mb4_general_ci"})
     */
    private $data = '';

    /**
     * @ORM\Column(type="integer")
     */
    private $ttl;

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): CompiledData
    {
        $this->data = $data;

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
