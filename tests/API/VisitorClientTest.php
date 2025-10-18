<?php

namespace Uxicodev\UnifiAccessApi\Tests\API;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\VisitorRequest;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
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
    public function a_visitor_can_be_retrieved(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/visitor/create.json')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $response = $unifiClient->visitor()->find(new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'));

        $this->assertInstanceOf(VisitorEntity::class, $response->data);
        $this->assertEquals('John', $response->data->first_name);
        $this->assertEquals('Doe', $response->data->last_name);
    }

    #[Test]
    public function a_visitor_find_error_throws_exception(): void
    {
        $mockHandler = new MockHandler([
            new Response(500, []),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(InvalidResponseException::class);
        $unifiClient->visitor()->find(new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'));
    }

    #[Test]
    public function a_list_of_visitors_can_be_retrieved(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/visitor/list.json')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $response = $unifiClient->visitor()->all();

        $this->assertCount(2, $response->data);
        $this->assertInstanceOf(VisitorEntity::class, $response->data[0]);
        $this->assertEquals('John', $response->data[0]->first_name);
        $this->assertEquals('Doe', $response->data[0]->last_name);
        $this->assertEquals('Jane', $response->data[1]->first_name);
        $this->assertEquals('Smith', $response->data[1]->last_name);
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

        $response = $unifiClient->visitor()->create(new VisitorRequest(
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
        $unifiClient->visitor()->create(new VisitorRequest(
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
        $unifiClient->visitor()->create(new VisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
        ));
    }

    #[Test]
    public function edit_visitor_without_id_throws_error(): void
    {
        $mockHandler = new MockHandler([]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(InvalidArgumentException::class);
        $unifiClient->visitor()->update(new VisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
        ));
    }

    #[Test]
    public function a_visitor_can_be_edited(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/visitor/create.json')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $response = $unifiClient->visitor()->update(new VisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
            id: new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'),
        ));
        $this->assertInstanceOf(VisitorEntity::class, $response->data);
        $this->assertEquals('John', $response->data->first_name);
        $this->assertEquals('Doe', $response->data->last_name);
    }

    #[Test]
    public function a_failed_edit_throws_an_exception(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, []),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(InvalidResponseException::class);

        $response = $unifiClient->visitor()->update(new VisitorRequest(
            'Saul',
            'Goodman',
            Carbon::now(),
            Carbon::now(),
            VisitReason::Business,
            id: new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'),
        ));
    }

    #[Test]
    public function a_visitor_can_be_deleted(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['code' => 'SUCCESS', 'msg' => 'success'])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $response = $unifiClient->visitor()->delete(new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'));

        $this->assertEquals('SUCCESS', $response->code);
        $this->assertEquals('success', $response->msg);
    }

    #[Test]
    public function a_visitor_delete_failure_throws_an_exception(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, []),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        $unifiClient = new UnifiClient($client);

        $this->expectException(InvalidResponseException::class);
        $unifiClient->visitor()->delete(new UuidV4('8564ce90-76ba-445f-b78b-6cca39af0130'));

    }
}
