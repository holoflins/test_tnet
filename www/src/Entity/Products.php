<?php

namespace App\Entity;

class Products implements EntityInterface
{
    use EntityTrait;

    /** @var  string */
    private $name;

    /** @var Category */
    private $category;

    /** @var string */
    private $SKU;

    /** @var float */
    private $price;

    /** @var int */
    private $quantity;

    /**
     * @param string $name
     * @return Products
     */
    public function setName(string $name): Products
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

    /**
     * @param Category $category
     * @return Products
     */
    public function setCategory(Category $category): Products
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param string $SKU
     * @return Products
     */
    public function setSKU(string $SKU): Products
    {
        $this->SKU = $SKU;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSKU(): ?string
    {
        return $this->SKU;
    }

    /**
     * @param float $price
     * @return Products
     */
    public function setPrice(float $price): Products
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param int $quantity
     * @return Products
     */
    public function setQuantity(int $quantity): Products
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}