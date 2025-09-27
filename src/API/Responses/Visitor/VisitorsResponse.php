<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\Visitor;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\Entities\VisitorEntity;

class VisitorsResponse
{
    /**
     * @param  Collection<int, VisitorEntity>  $data
     */
    public function __construct(
        public readonly string $code,
        public readonly Collection $data,
        public readonly string $msg
    ) {}

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        /** @var Collection<int, VisitorEntity> $visitors */
        $visitors = collect($response['data'] ?? [])->map(fn ($item) => VisitorEntity::fromArray($item));

        return new self(
            $response['code'] ?? '',
            $visitors,
            $response['msg'] ?? ''
        );
    }
}
