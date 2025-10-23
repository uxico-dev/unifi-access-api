<?php

namespace Uxicodev\UnifiAccessApi\Entities\System;

use Carbon\Carbon;

readonly class SystemLogEntity
{
    /** @param SystemLogTargetEntity[] $target */
    public function __construct(
        public Carbon $timestamp,
        public string $_id,
        public SystemLogActorEntity $actor,
        public SystemLogAuthenticationEntity $authentication,
        public SystemLogEventEntity $event,
        public array $target,
        public string $tag
    ) {}

    /** @param  array<array-key, mixed>  $data */
    public static function fromArray(array $data): self
    {
        $source = $data['_source'] ?? [];

        return new self(
            Carbon::parse($data['@timestamp'] ?? ''),
            $data['_id'] ?? '',
            SystemLogActorEntity::fromArray($source['actor'] ?? []),
            SystemLogAuthenticationEntity::fromArray($source['authentication'] ?? []),
            SystemLogEventEntity::fromArray($source['event'] ?? []),
            array_map(fn ($t) => SystemLogTargetEntity::fromArray($t), $source['target'] ?? []),
            $data['tag'] ?? ''
        );
    }
}
