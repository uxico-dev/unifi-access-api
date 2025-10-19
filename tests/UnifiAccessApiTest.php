<?php

namespace Uxicodev\UnifiAccessApi\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use Uxicodev\UnifiAccessApi\UnifiAccessApi;

class UnifiAccessApiTest extends TestCase
{
    public function test_client_uses_correct_base_uri_and_headers(): void
    {
        $baseUri = 'https://example.com/api/';
        $apiKey = 'test-key';
        $this->app['config']->set('unifi-access-api.unifi.uri', $baseUri);
        $this->app['config']->set('unifi-access-api.unifi.api_key', $apiKey);
        $this->app['config']->set('unifi-access-api.unifi.ssl_verify', false);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['code' => 'SUCCESS', 'msg' => 'OK'])),
        ]);
        $handlerStack = HandlerStack::create($mock);

        // History middleware to capture requests
        $history = [];
        $historyMiddleware = Middleware::history($history);
        $handlerStack->push($historyMiddleware);

        $unifiAccessApi = new UnifiAccessApi;
        $client = $unifiAccessApi->getClient(['handler' => $handlerStack]);

        $client->get('test');

        $this->assertCount(1, $history);

        $request = $history[0]['request'];
        $this->assertStringStartsWith($baseUri, (string) $request->getUri());
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals($apiKey, $request->getHeaderLine('Authorization'));
    }
}
