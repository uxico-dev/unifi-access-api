<?php

namespace Uxicodev\UnifiAccessApi\Entities\System;

use Carbon\Carbon;

readonly class SystemLogEventEntity
{
    public function __construct(
        public string $display_message,
        public Carbon $published,
        public string $reason,
        public string $result,
        public string $type
    ) {}

    /** @param  array<array-key, string>  $data */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['display_message'] ?? '',
            isset($data['published']) ? Carbon::createFromTimestampMs($data['published']) : Carbon::now(),
            $data['reason'] ?? '',
            $data['result'] ?? '',
            $data['type'] ?? ''
        );
    }
}
