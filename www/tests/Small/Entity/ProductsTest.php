<?php

namespace App\Tests\Small\Entity;

use App\Entity\Category;
use App\Entity\Products;
use Hatest\Interfaces\GetterSetterInterface;
use Hatest\Traits\GetterTrait;
use Hatest\Traits\SetterTrait;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase implements GetterSetterInterface
{
    use GetterTrait, SetterTrait;

    /** {@inheritdoc} */
    public function init(): Products
    {
        return new Products();
    }

    /** {@inheritdoc} */
    public function providerGetterAndSetter(): array
    {
        return [
            ['name', 'name'],
            ['category', new Category()],
            ['SKU', 'SKU'],
            ['price', 40.2],
            ['quantity', 42]
        ];
    }
}