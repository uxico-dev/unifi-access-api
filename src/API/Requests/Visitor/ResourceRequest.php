<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Uxicodev\UnifiAccessApi\API\Enums\ResourceType;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

class ResourceRequest
{
    public function __construct(
        public readonly UuidV4 $id,
        public readonly ?ResourceType $type = null
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new UuidV4($data['id']),
            ResourceType::from($data['type'])
        );
    }

    /**
     * @return array{id: string, type: string|null}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'type' => $this->type?->value,
        ];
    }
}
