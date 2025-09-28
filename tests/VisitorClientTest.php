<?php

namespace Uxicodev\UnifiAccessApi\Tests;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\Entities\VisitorEntity;
use Uxicodev\UnifiAccessApi\Tests\Overrides\ClientOverride;
use Uxicodev\UnifiAccessApi\UnifiAccessApiServiceProvider;

class VisitorClientTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [UnifiAccessApiServiceProvider::class];
    }

    #[Test]
    public function create_a_visitor_returns_visitor_response(): void
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/fixtures/visitor/create.json') ?? ''),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new ClientOverride($client);

        $response = $unifiClient->visitor()->create(new CreateVisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
        ));

        $this->assertInstanceOf(VisitorEntity::class, $response->data);
        $this->assertInstanceOf(Carbon::class, $response->data->create_time);
        $this->assertInstanceOf(Carbon::class, $response->data->start_time);
        $this->assertInstanceOf(Carbon::class, $response->data->end_time);
    }
}
