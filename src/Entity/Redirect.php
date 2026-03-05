<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Constants\RedirectConst;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Repository\RedirectRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=RedirectRepository::class, readOnly=true)
 */
class Redirect
{
    use IdTrait;
    use CreatedAtTrait;
    use ProjectTrait;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $hash;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected $path;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    protected $target;

    /**
     * @ORM\Column(type="integer", options={"default": 301})
     */
    protected $redirectStatus = RedirectConst::DEFAULT_STATUS;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        $this->hash = md5($path);

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getRedirectStatus(): int
    {
        return $this->redirectStatus;
    }

    public function setRedirectStatus(int $redirectStatus): self
    {
        $this->redirectStatus = $redirectStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash): void
    {
        $this->hash = $hash;
    }
}
