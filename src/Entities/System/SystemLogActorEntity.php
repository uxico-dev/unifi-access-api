<?php

namespace Uxicodev\UnifiAccessApi\Entities\System;

readonly class SystemLogActorEntity
{
    public function __construct(
        public string $alternate_id,
        public string $alternate_name,
        public string $display_name,
        public string $id,
        public string $type
    ) {}

    /** @param  array<array-key, string>  $data */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['alternate_id'] ?? '',
            $data['alternate_name'] ?? '',
            $data['display_name'] ?? '',
            $data['id'] ?? '',
            $data['type'] ?? ''
        );
    }
}
