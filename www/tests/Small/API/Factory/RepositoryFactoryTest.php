<?php

namespace App\Tests\API\Factory;

use App\API\Factory\RepositoryFactory;
use App\API\Resolver\EntityResolver;
use App\Entity\EntityInterface;
use App\Repository\RepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RepositoryFactoryTest extends TestCase
{
    /** @var EntityResolver */
    private $resolver;

    /** @var RegistryInterface */
    private $registry;

    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->resolver = $this->createMock(EntityResolver::class);
        $this->registry = $this->createMock(RegistryInterface::class);
    }

    /**
     * @return RepositoryFactory
     */
    public function init(): RepositoryFactory
    {
        return new RepositoryFactory($this->resolver, $this->registry);
    }

    public function testCreate()
    {
        $expected = $this->createMock(RepositoryInterface::class);

        $this->resolver->expects($this->once())
            ->method('resolveFullNameFromName')
            ->with('entityName')
            ->willReturn('toto');

        $this->registry->expects($this->once())
            ->method('getRepository')
            ->with('toto')
            ->willReturn($expected);

        $actual = $this->init()->create('entityName');
        $this->assertSame($expected, $actual);
    }
}