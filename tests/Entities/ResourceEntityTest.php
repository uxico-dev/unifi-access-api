<?php

namespace Uxicodev\UnifiAccessApi\Tests\Entities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Entities\ResourceEntity;

class ResourceEntityTest extends TestCase
{
    #[Test]
    public function to_array_appends_name_when_filled(): void
    {
        $entity = new ResourceEntity(
            id: new UuidV4('123e4567-e89b-12d3-a456-426614174000'),
            type: ResourceType::Door,
            name: 'Main Entrance'
        );
        $array = $entity->toArray();
        $this->assertArrayHasKey('name', $array);
        $this->assertEquals('Main Entrance', $array['name']);
    }

    #[Test]
    public function to_array_does_not_append_name_when_not_filled(): void
    {
        $entity = new ResourceEntity(
            id: new UuidV4('123e4567-e89b-12d3-a456-426614174000'),
            type: ResourceType::Door,
        );
        $array = $entity->toArray();
        $this->assertArrayNotHasKey('name', $array);
    }
}
