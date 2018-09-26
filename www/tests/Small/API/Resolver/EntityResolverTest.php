<?php

namespace Tests\Small\API\Resolver;

use App\Entity\Category;
use App\API\Exception\EntityNotFoundException;
use App\API\Resolver\EntityResolver;
use PHPUnit\Framework\TestCase;

class EntityResolverTest extends TestCase
{
    /**
     * @return EntityResolver
     */
    private function init(): EntityResolver
    {
        return new EntityResolver();
    }

    public function testResolveFullNameFromNameThrowError()
    {
        $this->expectException(EntityNotFoundException::class);

        $this->init()->resolveFullNameFromName('entity_not_found');
    }

    public function testResolveFullNameFromName()
    {
        $this->assertSame(Category::class, $this->init()->resolveFullNameFromName('Category'));
    }
}
