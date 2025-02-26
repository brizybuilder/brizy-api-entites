<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;


use Brizy\Bundle\ApiEntitiesBundle\Repository\CustomerRepository;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CodeInjectionPropertyTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\CreatedAtTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\DependenciesTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\ProjectTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\SEOTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\SocialTrait;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\UpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class, readOnly=true)
 */
class Customer
{
    use IdTrait;
    use ProjectTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use SEOTrait;
    use SocialTrait;
    use CodeInjectionPropertyTrait;
    use DependenciesTrait;

    public const SEO_DEFAULT_ENABLE_INDEXING = true;

    public const SEND_EMAIL_INVITE_DEFAULT = false;
    public const STATUS_IS_EMAIL_INVITED = false;
    public const PASSWORD_MIN_LENGTH = 6;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\Length(max="100")
     * @Assert\NotNull
     * @Assert\Email
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Length(max="50")
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Length(max="50")
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     *
     * @Assert\Length (max="20")
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $verifiedEmail = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\Choice(choices=CustomerConst::STATE_STATUSES)
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     *
     * @Gedmo\Versioned
     */
    private $state = CustomerConst::STATE_ENABLED;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $activationToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $resetPasswordToken = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", length=100, nullable=true)
     */
    private $resetPasswordTokenExpire = null;

    /**
     * @ORM\ManyToMany(targetEntity=CustomerGroup::class, inversedBy="customers", cascade={"persist"})
     * @ORM\JoinTable(name="customers_groups",
     *      joinColumns={@ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="customer_groups_id", referencedColumnName="id")}
     * )
     * @AppAssert\UniqueCustomerGroups(fields={"id"}, message="Field id must be unique", groups={"Default", "Update"})
     *
     * @Groups({ WebhookConst::ENTITY_MESSAGE_GROUP })
     */
    private $customerGroups;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     *
     * @Gedmo\Versioned
     */
    private $sendEmailInvite = self::SEND_EMAIL_INVITE_DEFAULT;

    private $activationUrl = null;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min="6", max="255")
     */
    private $password;

    /**
     * @var string
     */
    private $passwordConfirm;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     */
    private $isEmailInvited = self::STATUS_IS_EMAIL_INVITED;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $userName;

    /**
     * @ORM\OneToOne(targetEntity=PageData::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $pageData;

    /**
     * @ORM\OneToOne(targetEntity=CompiledHtml::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledHtml;

    /**
     * @var CompiledScripts
     *
     * @ORM\OneToOne(targetEntity=CompiledScripts::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledScripts;

    /**
     * @var CompiledStyles
     *
     * @ORM\OneToOne(targetEntity=CompiledStyles::class, cascade={"persist", "remove"}, fetch="LAZY")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="SET NULL")
     *
     * @Gedmo\Versioned
     */
    private $compiledStyles;

    public function __construct()
    {
        $this->customerGroups = new ArrayCollection();
        $this->pageData = new PageData();
        $this->compiledScripts = new CompiledScripts();
        $this->compiledStyles = new CompiledStyles();
        $this->compiledHtml = new CompiledHtml();
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm($passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getVerifiedEmail(): ?bool
    {
        return $this->verifiedEmail;
    }

    public function setVerifiedEmail(bool $verifiedEmail): self
    {
        $this->verifiedEmail = $verifiedEmail;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    /**
     * @return Collection|CustomerGroup[]
     */
    public function getCustomerGroups(): Collection
    {
        return $this->customerGroups;
    }

    public function addCustomerGroup(CustomerGroup $customerGroup): self
    {
        if (!$this->customerGroups->contains($customerGroup)) {
            $this->customerGroups[] = $customerGroup;
        }

        return $this;
    }

    public function removeCustomerGroup(CustomerGroup $customerGroup): self
    {
        $this->customerGroups->removeElement($customerGroup);

        return $this;
    }

    public function setCustomerGroups(Collection $customerGroups): self
    {
        $this->customerGroups = $customerGroups;

        return $this;
    }

    public function getSendEmailInvite(): bool
    {
        return $this->sendEmailInvite;
    }

    public function setSendEmailInvite(bool $sendEmailInvite): void
    {
        $this->sendEmailInvite = $sendEmailInvite;
    }

    public function getActivationUrl(): ?string
    {
        return $this->activationUrl;
    }

    public function setActivationUrl(?string $activationUrl): void
    {
        $this->activationUrl = $activationUrl;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    public function getResetPasswordTokenExpire(): ?\DateTime
    {
        return $this->resetPasswordTokenExpire;
    }

    public function setResetPasswordTokenExpire(?\DateTime $resetPasswordTokenExpire): self
    {
        $this->resetPasswordTokenExpire = $resetPasswordTokenExpire;

        return $this;
    }

    public function getIsEmailInvited(): ?bool
    {
        return $this->isEmailInvited;
    }

    public function setIsEmailInvited(bool $isEmailInvited): self
    {
        $this->isEmailInvited = $isEmailInvited;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPageData(): ?PageData
    {
        return $this->pageData;
    }

    public function setPageData(PageData $pageData): self
    {
        $this->pageData = $pageData ?? new PageData();

        return $this;
    }

    /**
     * @return mixed
     *
     * @var CompiledHtml
     */
    public function getCompiledHtml()
    {
        return $this->compiledHtml ?? $this->compiledHtml = new CompiledHtml();
    }

    /**
     * @param mixed $compiledHtml
     */
    public function setCompiledHtml(CompiledHtml $compiledHtml): self
    {
        $this->compiledHtml = $compiledHtml ?? new CompiledHtml();

        return $this;
    }

    public function getCompiledScripts(): CompiledScripts
    {
        return $this->compiledScripts ?? $this->compiledScripts = new CompiledScripts();
    }

    /**
     * @param mixed $compiledScripts
     */
    public function setCompiledScripts(CompiledScripts $compiledScripts): self
    {
        $this->compiledScripts = $compiledScripts;

        return $this;
    }

    /**
     * @return CompiledStyles
     */
    public function getCompiledStyles()
    {
        return $this->compiledStyles ?? $this->compiledStyles = new CompiledStyles();
    }

    public function setCompiledStyles(CompiledStyles $compiledStyles): self
    {
        $this->compiledStyles = $compiledStyles;

        return $this;
    }
}
