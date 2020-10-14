<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class ControllerTestCase extends WebTestCase
{
    protected static ?KernelBrowser $client = null;

    protected $loader;

    protected array $fixtures = [];

    public function setUp()
    {
        parent::setUp();
        self::$client = self::createClient();

        $this->loader = self::$container->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->loadFixtures();
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

    protected function loadFixtures(): void
    {
        $this->loader->load($this->fixtures, [], [], PurgeMode::createTruncateMode());
    }
}
