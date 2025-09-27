<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Illuminate\Support\Collection;

class VisitorRequest
{
    /**
     * @param  ?Collection<int, ResourceRequest>  $resources
     */
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly int $start_time,
        public readonly int $end_time,
        public readonly VisitReason $visit_reason,
        public readonly ?string $remarks = null,
        public readonly ?string $mobile_phone = null,
        public readonly ?string $email = null,
        public readonly ?string $visitor_company = null,
        public readonly ?WeekScheduleRequest $week_schedule = null,
        public readonly ?Collection $resources = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $weekSchedule = WeekScheduleRequest::fromArray($data['week_schedule'] ?? []);
        $resources = collect($data['resources'] ?? [])->map(fn ($item) => ResourceRequest::fromArray($item));

        return new self(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['start_time'] ?? 0,
            $data['end_time'] ?? 0,
            VisitReason::from($data['visit_reason'] ?? ''),
            $data['remarks'] ?? '',
            $data['mobile_phone'] ?? '',
            $data['email'] ?? '',
            $data['visitor_company'] ?? '',
            $weekSchedule,
            $resources
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'remarks' => $this->remarks,
            'mobile_phone' => $this->mobile_phone,
            'email' => $this->email,
            'visitor_company' => $this->visitor_company,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'visit_reason' => $this->visit_reason->value,
            'week_schedule' => $this->week_schedule?->toArray(),
            'resources' => $this->resources?->map(fn ($item) => $item->toArray())->all(),
        ];
    }
}
