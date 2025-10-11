<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

readonly class ResourceTopologyEntity
{
    /** @param  Collection<array-key, DoorEntity>  $resources */
    public function __construct(
        public UuidV4 $id,
        public string $name,
        public Collection $resources,
        public ResourceType $type
    ) {}

    /** @param array<array-key, mixed> $data */
    public static function fromArray(array $data): self
    {
        $resources = collect($data['resources'] ?? [])
            ->map(fn ($item) => DoorEntity::fromArray($item));

        return new self(
            new UuidV4($data['id']),
            $data['name'] ?? '',
            $resources,
            ResourceType::from($data['type'] ?? ResourceType::Door->value)
        );
    }
}
