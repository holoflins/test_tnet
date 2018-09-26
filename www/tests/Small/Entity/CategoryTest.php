<?php

namespace App\Tests\Small\Entity;

use App\Entity\Category;
use Hatest\Interfaces\GetterSetterInterface;
use Hatest\Traits\GetterTrait;
use Hatest\Traits\SetterTrait;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase implements GetterSetterInterface
{
    use GetterTrait, SetterTrait;

    /** {@inheritdoc} */
    public function init(): Category
    {
        return new Category();
    }

    /** {@inheritdoc} */
    public function providerGetterAndSetter(): array
    {
        return [
            ['name', 'name']
        ];
    }
}