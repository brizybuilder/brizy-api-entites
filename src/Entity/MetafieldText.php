<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;

use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\MetafieldBase;
use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Brizy\Bundle\ApiEntitiesBundle\Repository\MetafieldTextRepository;

/**
 * @ORM\Table(name="metafield__text", uniqueConstraints={@UniqueConstraint(columns={"entity_id","metafield_id"})})
 * @ORM\Entity(repositoryClass=MetafieldTextRepository::class, readOnly=true)
 */
class MetafieldText extends MetafieldBase
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text" )
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
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
