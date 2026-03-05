<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Collections\CollectionType;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Repository\WebhookRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass=WebhookRepository::class, readOnly=true)
 */
class Webhook
{
    use IdTrait;
    use CreatedAtTrait;
    use ProjectTrait;

    public const HOOK_CREATE_DEFAULT_VALUE = false;
    public const HOOK_UPDATE_DEFAULT_VALUE = false;
    public const HOOK_DELETE_DEFAULT_VALUE = false;

    public const ENABLED_DEFAULT_VALUE = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $url;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $objectName;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": Webhook::HOOK_CREATE_DEFAULT_VALUE})
     */
    protected $hookCreate = self::HOOK_CREATE_DEFAULT_VALUE;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": Webhook::HOOK_UPDATE_DEFAULT_VALUE})
     */
    protected $hookUpdate = self::HOOK_UPDATE_DEFAULT_VALUE;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": Webhook::HOOK_DELETE_DEFAULT_VALUE})
     */
    protected $hookDelete = self::HOOK_DELETE_DEFAULT_VALUE;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": Webhook::ENABLED_DEFAULT_VALUE})
     */
    protected $enabled = Webhook::ENABLED_DEFAULT_VALUE;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionType::class)
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $collectionType;

    /**
     * Webhook constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollectionType(): ?CollectionType
    {
        return $this->collectionType;
    }

    public function setCollectionType(?CollectionType $collectionType): self
    {
        $this->collectionType = $collectionType;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getObjectName(): string
    {
        return $this->objectName;
    }

    public function setObjectName($objectName): self
    {
        $this->objectName = $objectName;

        return $this;
    }

    public function getHookCreate(): bool
    {
        return $this->hookCreate;
    }

    public function setHookCreate(bool $hookCreate): self
    {
        $this->hookCreate = $hookCreate;

        return $this;
    }

    public function getHookUpdate(): bool
    {
        return $this->hookUpdate;
    }

    public function setHookUpdate(bool $hookUpdate): self
    {
        $this->hookUpdate = $hookUpdate;

        return $this;
    }

    public function getHookDelete(): bool
    {
        return $this->hookDelete;
    }

    public function setHookDelete(bool $hookDelete): self
    {
        $this->hookDelete = $hookDelete;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
