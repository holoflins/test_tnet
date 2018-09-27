<?php

namespace App\Tests\Large\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiControllerTest extends WebTestCase
{
    use ApiProviderTrait;

    /** @var Client */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider providerList
     */
    public function testList(string $entityName)
    {
        $this->client->request('GET', '/api/'.$entityName);

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetOneProducts()
    {
        $this->client->request('GET', '/api/products/1');

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetOneCategory()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->client->request('GET', '/api/category/1');
    }
}