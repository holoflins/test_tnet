<?php

namespace App\Tests\Large\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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

    public function testCreateProducts()
    {
        $this->client->request(
            'POST',
            '/api/products',
            [],
            [],
            [],
            '{"name": "toto", "category": "Games", "sku": "A0006", "price": 69.99,"quantity": 20}'
        );

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_CREATED);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testUpdateProducts()
    {
        $this->client->request(
            'PUT',
            '/api/products/5',
            [],
            [],
            [],
            '{"name": "toto_updated", "category": "Games", "sku": "A0006", "price": 69.99,"quantity": 20}'
        );

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testDeleteProducts()
    {
        $this->client->request('DELETE', '/api/products/5');

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_NO_CONTENT);
    }

    public function testGetOneCategory()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->client->request('GET', '/api/category/1');
    }

    public function testCreateCategory()
    {
        $this->expectException(MethodNotAllowedHttpException::class);

        $this->client->request('POST','/api/category');
    }

    public function testUpdateCategory()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->client->request('PUT','/api/category/1');
    }

    public function testDeleteCategory()
    {
        $this->expectException(NotFoundHttpException::class);

        $this->client->request('DELETE','/api/category/1');
    }
}