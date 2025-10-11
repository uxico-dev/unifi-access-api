<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

readonly class DoorEntity
{
    public function __construct(
        public UuidV4 $id,
        public bool $is_bind_hub,
        public string $name,
        public ResourceType $type
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
