<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\Visitor;

use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\Entities\VisitorEntity;

readonly class VisitorResponse extends UnifiResponse
{
    public function __construct(
        string $code,
        string $msg,
        public VisitorEntity $data,
    ) {
        parent::__construct($code, $msg);
    }

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        return new self(
            $response['code'] ?? '',
            $response['msg'] ?? '',
            VisitorEntity::fromArray($response['data'] ?? []),
        );
    }
}
