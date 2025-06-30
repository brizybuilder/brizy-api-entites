<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity;


use Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Brizy\Bundle\ApiEntitiesBundle\Repository\MetafieldRepository;
/**
 * @ORM\Table(name="metafield", uniqueConstraints={@UniqueConstraint(columns={"node_id","name"})})
 * @ORM\Entity(repositoryClass=MetafieldRepository::class, readOnly=true)
 */
class Metafield
{
    use IdTrait;
    use TimestampableEntity;

    public const TYPE_VARCHAR = 'varchar';
    public const TYPE_INT = 'int';
    public const TYPE_TEXT = 'text';
    public const TYPES = [
        self::TYPE_INT,
        self::TYPE_TEXT,
        self::TYPE_VARCHAR,
    ];

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", options={"default" = "int"} )
     */
    protected $type = self::TYPE_INT;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
