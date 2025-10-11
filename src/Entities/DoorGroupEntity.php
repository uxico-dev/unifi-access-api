<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class DoorGroupEntity
{
    /** @param  Collection<array-key, ResourceTopologyEntity>  $resource_topologies */
    public function __construct(
        public readonly UuidV4 $id,
        public readonly string $name,
        public readonly Collection $resource_topologies,
        public readonly ResourceType $type
    ) {}

    /** @param array<array-key, mixed> $data */
    public static function fromArray(array $data): self
    {
        $topologies = collect($data['resource_topologies'] ?? [])
            ->map(fn ($item) => ResourceTopologyEntity::fromArray($item));

        return new self(
            new UuidV4($data['id']),
            $data['name'] ?? '',
            $topologies,
            ResourceType::from($data['type'] ?? ResourceType::DoorGroup->value)
        );
    }
}
