<?php

declare(strict_types=1);

namespace Uxicodev\UnifiAccessApi\Tests\API\Requests\System;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Enums\SystemLogTopic;
use Uxicodev\UnifiAccessApi\API\Requests\System\SystemLogRequest;
use Uxicodev\UnifiAccessApi\Exceptions\ValidationException;

class SystemLogRequestTest extends TestCase
{
    public function test_from_array_success(): void
    {
        $data = [
            'topic' => SystemLogTopic::DoorOpenings->value,
            'since' => Carbon::now()->unix(),
            'until' => Carbon::now()->addHour()->unix(),
            'actor_id' => '8564ce90-76ba-445f-b78b-6cca39af0130',
            'page_size' => 10,
            'page_num' => 1,
        ];
        $request = SystemLogRequest::fromArray($data);
        $this->assertInstanceOf(SystemLogRequest::class, $request);
        $this->assertEquals($data['topic'], $request->topic->value);
        $this->assertEquals($data['since'], $request->since->unix());
        $this->assertEquals($data['until'], $request->until->unix());
        $this->assertEquals($data['actor_id'], $request->actor_id->getValue());
        $this->assertEquals($data['page_size'], $request->page_size);
        $this->assertEquals($data['page_num'], $request->page_num);
    }

    public function test_from_array_validation_fails(): void
    {
        $data = [
            // 'topic' is missing
            'since' => Carbon::now()->unix(),
        ];
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('SystemLogRequest validation failed.');
        SystemLogRequest::fromArray($data);
    }

    public function test_from_array_until_not_after_since(): void
    {
        $now = Carbon::now()->unix();
        $data = [
            'topic' => SystemLogTopic::DoorOpenings->value,
            'since' => $now,
            'until' => $now, // not after since
        ];
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('SystemLogRequest validation failed.');
        try {
            SystemLogRequest::fromArray($data);
        } catch (ValidationException $e) {
            $errors = $e->errors->toArray();
            $this->assertArrayHasKey('until', $errors);
            $this->assertStringContainsString("'until' must be after 'since'.", $errors['until'][0]);
            throw $e;
        }
    }
}
