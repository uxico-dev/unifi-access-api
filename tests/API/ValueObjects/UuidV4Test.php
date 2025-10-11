<?php

namespace Uxicodev\UnifiAccessApi\Tests\API\ValueObjects;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class UuidV4Test extends TestCase
{
    #[Test]
    public function it_accepts_valid_uuid_v4(): void
    {
        $uuid = new UuidV4('123e4567-e89b-12d3-a456-426614174000');
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', $uuid->getValue());
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', (string) $uuid);
    }

    #[Test]
    public function it_throws_exception_for_invalid_uuid_v4(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new UuidV4('invalid-uuid');
    }
}
