<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Illuminate\Support\Collection;

readonly class WeekScheduleRequest
{
    /**
     * @param  Collection<string, Collection<int, ScheduleDayRequest>>  $days
     */
    public function __construct(
        public Collection $days
    ) {}

    /**
     * @param  array<string, array<int, array<string, string>>>  $data
     */
    public static function fromArray(array $data): self
    {
        $days = collect($data)->map(function ($day) {
            return collect($day)->map(fn ($item) => ScheduleDayRequest::fromArray($item));
        });

        return new self($days);
    }

    /**
     * @return array<string, array<int, array{start_time: int|null, end_time: int|null}>>
     */
    public function toArray(): array
    {
        return $this->days->map(function ($day) {
            return $day->map(fn ($item) => $item->toArray())->all();
        })->all();
    }
}
