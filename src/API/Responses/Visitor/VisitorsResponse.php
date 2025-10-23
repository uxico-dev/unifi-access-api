<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\Visitor;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\Entities\Visitor\VisitorEntity;

readonly class VisitorsResponse extends UnifiResponse
{
    /**
     * @param  Collection<int, VisitorEntity>  $data
     */
    public function __construct(
        string $code,
        string $msg,
        public readonly Collection $data,
    ) {
        parent::__construct($code, $msg);
    }

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        /** @var Collection<int, VisitorEntity> $visitors */
        $visitors = collect($response['data'] ?? [])->map(fn ($item) => VisitorEntity::fromArray($item));

        return new self(
            $response['code'] ?? '',
            $response['msg'] ?? '',
            $visitors,
        );
    }
}
