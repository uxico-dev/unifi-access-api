<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class DoorEntity
{
    public function __construct(
        public readonly UuidV4 $id,
        public readonly bool $is_bind_hub,
        public readonly string $name,
        public readonly ResourceType $type
    ) {}

    /** @param array<array-key, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            new UuidV4($data['id']),
            $data['is_bind_hub'] ?? false,
            $data['name'] ?? '',
            ResourceType::from($data['type'] ?? ResourceType::Door->value)
        );
    }
}
