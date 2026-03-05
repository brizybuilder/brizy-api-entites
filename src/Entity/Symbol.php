<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\UpdatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Repository\SymbolRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=SymbolRepository::class, readOnly=true)
 */
class Symbol
{
    use IdTrait;
    use ProjectTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $className;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $componentTarget;

    /**
     * @ORM\Column(type="integer")
     */
    private $version = 1;

    /**
     * @ORM\OneToOne(targetEntity="Brizy\Bundle\ApiEntitiesBundle\Entity\SymbolData", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="symbol_data_id", referencedColumnName="id")
     */
    private $model;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): void
    {
        $this->uid = $uid;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    public function getModel(): SymbolData
    {
        return $this->model;
    }

    public function setModel(SymbolData $model): void
    {
        $this->model = $model;
        $this->model->setProject($this->getProject());
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function setClassName(string $className): Symbol
    {
        $this->className = $className;

        return $this;
    }

    public function getComponentTarget(): string
    {
        return $this->componentTarget;
    }

    public function setComponentTarget(string $componentTarget): Symbol
    {
        $this->componentTarget = $componentTarget;

        return $this;
    }
}
