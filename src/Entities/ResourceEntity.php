<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class ResourceEntity
{
    public function __construct(
        public readonly UuidV4 $id,
        public readonly ResourceType $type,
        public readonly ?string $name = null,
    ) {}

    /** @param  array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            new UuidV4($data['id']),
            ResourceType::from($data['type']),
            $data['name'] ?? '',
        );
    }

    /** @return array{name?: non-falsy-string, id: string, type: 'building'|'door'|'door_group'|'floor'} */
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'type' => $this->type->value,
        ] + ($this->name ? ['name' => $this->name] : []);
    }
}
