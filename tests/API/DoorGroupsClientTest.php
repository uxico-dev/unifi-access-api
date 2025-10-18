<?php

namespace Uxicodev\UnifiAccessApi\Tests\API;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Responses\Resource\ResourceGroupResponse;
use Uxicodev\UnifiAccessApi\Client\Client as UnifiClient;

class DoorGroupsClientTest extends TestCase
{
    #[Test]
    public function test_get_topology(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/doorgroups/topology.json')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $response = $unifiClient->doorGroups()->getTopology();

        $this->assertInstanceOf(ResourceGroupResponse::class, $response);
        $this->assertEquals('All Doors', $response->data[0]->name);
        $this->assertEquals('Main Floor', $response->data[0]->resource_topologies[0]->name);
        $this->assertEquals('customized group', $response->data[1]->name);
    }
}
