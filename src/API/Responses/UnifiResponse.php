<?php

namespace Uxicodev\UnifiAccessApi\API\Responses;

readonly class UnifiResponse
{
    public function __construct(
        public string $code,
        public string $msg
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
