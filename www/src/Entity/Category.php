<?php

namespace App\Entity;

class Category implements EntityInterface
{
    use EntityTrait;

    /** @var string */
    private $name;

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}