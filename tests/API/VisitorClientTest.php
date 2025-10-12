<?php

namespace Uxicodev\UnifiAccessApi\Tests\API;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\Client\Client as UnifiClient;
use Uxicodev\UnifiAccessApi\Entities\VisitorEntity;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;
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
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/visitor/create.json')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

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
        $unifiClient->visitor()->create(new CreateVisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
        ));
    }

    #[Test]
    public function non_success_code_in_response_throws_unifi_api_error_exception(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['code' => 'CODE_PARAMS_INVALID', 'msg' => 'Invalid parameters'])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(UnifiApiErrorException::class);
        $unifiClient->visitor()->create(new CreateVisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
        ));
    }
}
