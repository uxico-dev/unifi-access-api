<?php

namespace Uxicodev\UnifiAccessApi\Tests\API;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Enums\SystemLogTopic;
use Uxicodev\UnifiAccessApi\API\Requests\System\SystemLogRequest;
use Uxicodev\UnifiAccessApi\API\Responses\System\SystemLogsResponse;
use Uxicodev\UnifiAccessApi\Client\Client as UnifiClient;
use Uxicodev\UnifiAccessApi\Entities\System\SystemLogEntity;

class SystemClientTest extends TestCase
{
    #[Test]
    public function test_logs_returns_expected_response(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../fixtures/system/logs.json')),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);
        $unifiClient = new UnifiClient($client);

        $request = new SystemLogRequest(
            topic: SystemLogTopic::DoorOpenings,
            since: Carbon::createFromTimestamp(1690770546),
            until: Carbon::createFromTimestamp(1690771546),
            actor_id: null,
            page_size: 1,
            page_num: 25
        );

        $response = $unifiClient->system()->logs($request);

        $this->assertInstanceOf(SystemLogsResponse::class, $response);
        $this->assertEquals('SUCCESS', $response->code);
        $this->assertEquals(1, $response->page);
        $this->assertEquals(4, $response->total);
        $this->assertNotEmpty($response->logs);
        $firstLog = $response->logs->first();
        $this->assertInstanceOf(SystemLogEntity::class, $firstLog);
        $this->assertEquals('N/A', $firstLog->actor->display_name);
        $this->assertEquals('NFC', $firstLog->authentication->credential_provider);
        $this->assertEquals('Access Denied / Unknown (NFC)', $firstLog->event->display_message);
        $this->assertEquals('BLOCKED', $firstLog->event->result);
        $this->assertEquals('access.door.unlock', $firstLog->event->type);
        $this->assertEquals('UA-HUB-3855', $firstLog->target[0]->display_name);
        $this->assertEquals('access', $firstLog->tag);
        $this->assertInstanceOf(Carbon::class, $firstLog->timestamp);
        $this->assertInstanceOf(Carbon::class, $firstLog->event->published);
    }
}
