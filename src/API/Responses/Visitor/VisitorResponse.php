<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\Visitor;

use Uxicodev\UnifiAccessApi\Entities\VisitorEntity;

class VisitorResponse
{
    public function __construct(
        public readonly string $code,
        public readonly VisitorEntity $data,
        public readonly string $msg
    ) {}

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response['code'] ?? '',
            VisitorEntity::fromArray($response['data'] ?? []),
            $response['msg'] ?? ''
        );
    }
}
