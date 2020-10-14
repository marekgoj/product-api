<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends ControllerTestCase
{
    protected array $fixtures = [
        'tests/Resources/fixtures/product.php'
    ];

    public function testPost_CorrectData_OK(): void
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'correct name',
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('id', $response);
        $this->assertObjectHasAttribute('name', $response);
        $this->assertObjectHasAttribute('price', $response);
        $this->assertObjectHasAttribute('priceInPLN', $response);
        $this->assertEquals('correct name', $response->name);
        $this->assertEquals('1.00 PLN', $response->priceInPLN);
    }

    public function testPost_PriceIsZero_OK()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'name pensh',
            'price' => 0
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertEquals('0.00 PLN', $response->priceInPLN);
    }

    public function testPost_EmptyData_ValidationError(): void
    {
        $this->sendRequest('api/product', Request::METHOD_POST);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testPost_NegativePrice_ValidationError()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'name poeny',
            'price' => -5
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('price', $response->violations);
    }

    public function testPost_NameTooShort_ValidationError()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'X',
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testPost_NameTooLong_ValidationError()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => str_repeat('X', 1000),
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testPost_NameAlreadyExists_ValidationError()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'existing product',
            'price' => 100
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('name', $response->violations);
    }

    public function testPost_PriceAsArray_ValidationError()
    {
        $this->sendRequest('api/product', Request::METHOD_POST, [
            'name' => 'name ndoet',
            'price' => ['array', 'of', 'strings']
        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->getResponseStatusCode());

        $response = $this->getDecodedResponseData();
        $this->assertObjectHasAttribute('price', $response->violations);
    }
}
