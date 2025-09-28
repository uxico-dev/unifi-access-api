<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;

class ResourceRequest
{
    public function __construct(
        public readonly string $id,
        public readonly ?ResourceType $type = null
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            ResourceType::from($data['type'])
        );
    }

    /**
     * @return array{id: string, type: string|null}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type?->value,
        ];
    }
}
