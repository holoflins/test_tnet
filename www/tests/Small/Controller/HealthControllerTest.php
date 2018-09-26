<?php

namespace App\Tests\Small\Controller;

use App\Controller\HealthController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;

class HealthControllerTest extends TestCase
{
    public function testHealth(): void
    {
        $controller = new HealthController();
        $container = $this->createMock(Container::class);
        $controller->setContainer($container);

        $container->expects($this->once())
            ->method('has')
            ->with('serializer')
            ->willReturn(false);

        $actual = $controller->health();

        $this->assertInstanceOf(Response::class, $actual);
        $this->assertSame(Response::HTTP_OK, $actual->getStatusCode());
    }
}