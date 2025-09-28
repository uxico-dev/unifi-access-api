<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class ResourceEntity
{
    public function __construct(
        public readonly UuidV4 $id,
        public readonly string $name,
        public readonly ResourceType $type
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new UuidV4($data['id']),
            $data['name'] ?? '',
            ResourceType::from($data['type'])
        );
    }
}
