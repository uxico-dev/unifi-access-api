<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

readonly class DoorGroupEntity
{
    /** @param  Collection<array-key, ResourceTopologyEntity>  $resource_topologies */
    public function __construct(
        public UuidV4 $id,
        public string $name,
        public Collection $resource_topologies,
        public ResourceType $type
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
