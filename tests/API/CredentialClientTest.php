<?php

namespace Uxicodev\UnifiAccessApi\Tests\API;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Client\Client as UnifiClient;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\UnifiAccessApiServiceProvider;

class CredentialClientTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [UnifiAccessApiServiceProvider::class];
    }

    #[Test]
    public function download_qr_code_returns_tmp_filestring(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../../README.md')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $tmpFilePath = $unifiClient->credential()->downloadQrCode(new UuidV4('f884ec72-5d05-4325-9b8e-2ae6ee0181b0'));

        $this->assertStringContainsString('Unifi Access API', file_get_contents($tmpFilePath));
    }

    #[Test]
    public function bad_request_response_throws_exception(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, []),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(InvalidResponseException::class);
        $unifiClient->credential()->downloadQrCode(new UuidV4('f884ec72-5d05-4325-9b8e-2ae6ee0181b0'));
    }
}
