<?php

namespace Uxicodev\UnifiAccessApi\API\ValueObjects;

class UuidV4
{
    public function __construct(private readonly string $value)
    {
        if (! preg_match('~^[[:xdigit:]]{8}(?:\-[[:xdigit:]]{4}){3}\-[[:xdigit:]]{12}$~i', $value)) {
            throw new \InvalidArgumentException("Invalid UUID v4 format: {$value}");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
