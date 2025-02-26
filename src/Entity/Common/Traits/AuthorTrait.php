<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Entity\Common\Traits;

use Brizy\Bundle\ApiEntitiesBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait AuthorTrait
{
    /**
     * @ORM\Column(type="integer", nullable=true, name="author_id")
     */
    protected $author;

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }
}
