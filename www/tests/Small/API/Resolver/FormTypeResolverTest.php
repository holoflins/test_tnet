<?php

namespace Tests\Small\API\Resolver;

use App\API\Exception\FormTypeNotFoundException;
use App\API\Resolver\FormTypeResolver;
use App\Form\ProductsType;
use PHPUnit\Framework\TestCase;

class FormTypeResolverTest extends TestCase
{
    /**
     * @return FormTypeResolver
     */
    private function init(): FormTypeResolver
    {
        return new FormTypeResolver();
    }

    public function testResolveFullNameFromNameThrowError()
    {
        $this->expectException(FormTypeNotFoundException::class);

        $this->init()->resolveFullNameFromName('form type_not_found');
    }

    public function testResolveFullNameFromName()
    {
        $this->assertSame(ProductsType::class, $this->init()->resolveFullNameFromName('Products'));
    }
}
