<?php

namespace Uxicodev\UnifiAccessApi\Entities;

class ResourceEntity
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $type
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            $data['name'] ?? '',
            $data['type'] ?? ''
        );
    }
}
