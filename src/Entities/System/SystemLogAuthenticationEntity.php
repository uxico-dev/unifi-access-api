<?php

namespace Uxicodev\UnifiAccessApi\Entities\System;

readonly class SystemLogAuthenticationEntity
{
    public function __construct(
        public string $credential_provider,
        public string $issuer
    ) {}

    /** @param  array<array-key, string>  $data */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['credential_provider'] ?? '',
            $data['issuer'] ?? ''
        );
    }
}
