<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use App\Annotation\GraphQLType;
use App\Constants\WebhookConst;
use Doctrine\ORM\Mapping as ORM;

trait SEOTrait
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $seo = [];

    public function getSeo(): array
    {
        return json_decode($this->seo, true) ?? [];
    }

    public function setSeo(array $seo): self
    {
        $this->seo = $seo ?? [];

        return $this;
    }
}
