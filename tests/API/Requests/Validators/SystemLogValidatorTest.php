<?php

declare(strict_types=1);

namespace Uxicodev\UnifiAccessApi\Tests\API\Requests\Validators;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Requests\Validators\SystemLogValidator;

class SystemLogValidatorTest extends TestCase
{
    public function test_passes_with_all_required_fields(): void
    {
        $data = [
            'topic' => 'DOOR_EVENT',
            'since' => Carbon::now()->unix(),
        ];
        $validator = new SystemLogValidator($data);
        $this->assertTrue($validator->passes());
        $this->assertEmpty($validator->getErrors()->toArray());
    }

    public function test_fails_when_topic_missing(): void
    {
        $data = [
            'since' => Carbon::now()->unix(),
        ];
        $validator = new SystemLogValidator($data);
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('topic', $validator->getErrors()->toArray());
    }

    public function test_fails_when_since_missing(): void
    {
        $data = [
            'topic' => 'DOOR_EVENT',
        ];
        $validator = new SystemLogValidator($data);
        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('since', $validator->getErrors()->toArray());
    }

    public function test_fails_when_both_required_fields_missing(): void
    {
        $data = [];
        $validator = new SystemLogValidator($data);
        $this->assertFalse($validator->passes());
        $errors = $validator->getErrors()->toArray();
        $this->assertArrayHasKey('topic', $errors);
        $this->assertArrayHasKey('since', $errors);
    }

    public function test_fails_when_required_fields_are_empty(): void
    {
        $data = [
            'topic' => '',
            'since' => null,
        ];
        $validator = new SystemLogValidator($data);
        $this->assertFalse($validator->passes());
        $errors = $validator->getErrors()->toArray();
        $this->assertArrayHasKey('topic', $errors);
        $this->assertArrayHasKey('since', $errors);
    }

    public function test_fails_when_until_not_after_since(): void
    {
        $since = Carbon::now()->unix();
        $until = $since; // 'until' is equal to 'since'
        $data = [
            'topic' => 'DOOR_EVENT',
            'since' => $since,
            'until' => $until,
        ];
        $validator = new SystemLogValidator($data);
        $this->assertFalse($validator->passes());
        $errors = $validator->getErrors()->toArray();
        $this->assertArrayHasKey('until', $errors);
        $this->assertStringContainsString(
            "'until' must be after 'since'.",
            $errors['until'][0]
        );
    }
}
