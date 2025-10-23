<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\Resource;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\Entities\DoorGroups\DoorGroupEntity;

readonly class ResourceGroupResponse extends UnifiResponse
{
    /**
     * @param  Collection<int, DoorGroupEntity>  $data
     */
    public function __construct(
        string $code,
        string $msg,
        public readonly Collection $data,
    ) {
        parent::__construct($code, $msg);
    }

    public static function fromArray(array $response): self
    {
        $data = collect($response['data'] ?? [])
            ->map(fn ($item) => DoorGroupEntity::fromArray($item));

        return new self(
            $response['code'] ?? '',
            $response['msg'] ?? '',
            $data,
        );
    }
}
