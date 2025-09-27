<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

class ScheduleDayRequest
{
    public function __construct(
        public readonly string $start_time,
        public readonly string $end_time
    ) {}

    /**
     * @param  array<string, string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['start_time'] ?? '',
            $data['end_time'] ?? ''
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
