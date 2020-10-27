<?php

declare(strict_types=1);

namespace App\Tests\UI\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ControllerTestCase extends WebTestCase
{
    protected static ?KernelBrowser $client = null;

    public function setUp()
    {
        parent::setUp();
        try {
            self::$client = self::createClient();
        } catch (\Exception $e) {
        }
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$client = self::createClient();

        // clear database
        self::$container->get('doctrine')->getConnection()->executeQuery('TRUNCATE read_model_product');
        self::$container->get('doctrine')->getConnection()->executeQuery('TRUNCATE product');
    }

    protected function sendRequest(string $uri, string $method = Request::METHOD_GET, array $content = []): Crawler
    {
        return self::$client->request(
            $method,
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($content)
        );
    }

    protected function getResponseStatusCode(): int
    {
        return self::$client->getResponse()->getStatusCode();
    }

    protected function getDecodedResponse($asArray = false)
    {
        return json_decode(self::$client->getResponse()->getContent(), $asArray);
    }

    protected function getDecodedResponseData($asArray = false)
    {
        $decodedResponse = $this->getDecodedResponse($asArray);

        return $asArray ? $decodedResponse['data'] : $decodedResponse->data;
    }

    protected function getResponseHeaders(): ResponseHeaderBag
    {
        return self::$client->getResponse()->headers;
    }
}
