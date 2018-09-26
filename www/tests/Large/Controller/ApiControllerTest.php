<?php

namespace App\Tests\Large\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testList()
    {
        $this->client->request('GET', '/api/category');

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetOne()
    {
        $this->client->request('GET', '/api/category/1');

        $this->assertSame($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->assertJson($this->client->getResponse()->getContent());
    }
}