<?php

namespace Uxicodev\UnifiAccessApi\API\Responses\System;

use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\Entities\System\SystemLogEntity;

readonly class SystemLogsResponse extends UnifiResponse
{
    /** @param  Collection<int, SystemLogEntity>  $logs */
    public function __construct(
        string $code,
        public Collection $logs,
        public int $page,
        public int $total,
    ) {
        parent::__construct($code, '');
    }

    /**
     * @param  array<string, mixed>  $response
     */
    public static function fromArray(array $response): self
    {
        $hits = collect($response['data']['hits'] ?? [])->map(fn ($item) => SystemLogEntity::fromArray($item));

        return new self(
            $response['code'] ?? '',
            $hits,
            $response['page'] ?? 1,
            $response['total'] ?? 0
        );
    }
}
