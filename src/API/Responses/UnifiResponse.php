<?php

namespace Uxicodev\UnifiAccessApi\API\Responses;

class UnifiResponse
{
    public function __construct(
        public readonly string $code,
        public readonly string $msg
    ) {}

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response['code'] ?? '',
            $response['msg'] ?? ''
        );
    }
}
