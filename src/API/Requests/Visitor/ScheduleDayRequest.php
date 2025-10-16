<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Carbon\Carbon;

readonly class ScheduleDayRequest
{
    public function __construct(
        public ?Carbon $start_time,
        public ?Carbon $end_time
    ) {}

    /**
     * @param  array<string, string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['start_time'] ? Carbon::parse($data['start_time']) : null,
            $data['end_time'] ? Carbon::parse($data['end_time']) : null
        );
    }

    /**
     * @return array{start_time: int|null, end_time: int|null}
     */
    public function toArray(): array
    {
        return [
            'start_time' => $this->start_time?->unix(),
            'end_time' => $this->end_time?->unix(),
        ];
    }
}
