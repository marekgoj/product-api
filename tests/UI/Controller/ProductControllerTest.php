<?php

declare(strict_types=1);

namespace App\Tests\UI\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends ControllerTestCase
{
    public function testPost_CorrectData_Created(): ?string
    {
        $this->sendRequest('api/products', Request::METHOD_POST, [
            'name' => 'correct name',
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseHeaders()->has('location'));

        return $this->getResponseHeaders()->get('location');
    }

    public function testPost_PriceIsZero_Created()
    {
        $this->sendRequest('api/products', Request::METHOD_POST, [
            'name' => 'name pensh',
            'price' => 0
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $this->getResponseStatusCode());
        $this->assertTrue($this->getResponseHeaders()->has('location'));
    }

    /**
     * @depends testPost_CorrectData_Created
     */
    public function testPost_NameAlreadyExists_ValidationError()
    {
        $this->sendRequest('api/products', Request::METHOD_POST, [
            'name' => 'correct name',
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testPost_PriceAsArray_ValidationError()
    {
        $this->sendRequest('api/products', Request::METHOD_POST, [
            'name' => 'name ndoet',
            'price' => ['array', 'of', 'strings']
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('price', $response->violations);
    }

    /**
     * @depends testPost_CorrectData_Created
     * @param string|null $location
     */
    public function testGet_ReadExistingProduct_OK(?string $location): void
    {
        $this->sendRequest(sprintf($location), Request::METHOD_GET);

        $this->assertEquals(Response::HTTP_OK, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('id', $response);
        $this->assertObjectHasAttribute('name', $response);
        $this->assertObjectHasAttribute('price', $response);
        $this->assertObjectHasAttribute('priceInPLN', $response);
        $this->assertEquals('correct name', $response->name);
        $this->assertEquals('1.00 PLN', $response->priceInPLN);
    }

    public function testGet_ReadNotExistingProduct_NotFound(): void
    {
        $this->sendRequest('api/products/d5e3c33b-2b81-4c70-9e03-804756c49001', Request::METHOD_GET);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->getResponseStatusCode());
    }
}
