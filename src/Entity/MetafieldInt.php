<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\MetafieldBase;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Brizy\Bundle\ApiEntitiesBundle\Repository\MetafieldIntRepository;

/**
 * @ORM\Table(name="metafield__int", uniqueConstraints={@UniqueConstraint(columns={"entity_id","metafield_id"})})
 * @ORM\Entity(repositoryClass=MetafieldIntRepository::class, readOnly=true)
 */
class MetafieldInt extends MetafieldBase
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="integer" )
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setValue($value): MetafieldInt
    {
        $this->value = $value;

        return $this;
    }
}
