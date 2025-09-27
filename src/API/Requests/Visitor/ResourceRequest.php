<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

class ResourceRequest
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $type = null
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            $data['type'] ?? null
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'type' => $this->type,
        ], fn ($v) => $v !== null);
    }
}
