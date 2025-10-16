<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

readonly class VisitorRequest
{
    /**
     * @param  ?Collection<int, ResourceRequest>  $resources
     */
    public function __construct(
        public string $first_name,
        public string $last_name,
        public Carbon $start_time,
        public Carbon $end_time,
        public VisitReason $visit_reason,
        public ?string $remarks = null,
        public ?string $mobile_phone = null,
        public ?string $email = null,
        public ?string $visitor_company = null,
        public ?WeekScheduleRequest $week_schedule = null,
        public ?Collection $resources = null,
        public ?UuidV4 $id = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $weekSchedule = WeekScheduleRequest::fromArray($data['week_schedule'] ?? []);
        $resources = collect($data['resources'] ?? [])->map(fn ($item) => ResourceRequest::fromArray($item));

        return new self(
            $data['first_name'],
            $data['last_name'],
            $data['start_time'],
            $data['end_time'],
            VisitReason::from($data['visit_reason']),
            $data['remarks'] ?? '',
            $data['mobile_phone'] ?? '',
            $data['email'] ?? '',
            $data['visitor_company'] ?? '',
            $weekSchedule,
            $resources,
            isset($data['id']) ? new UuidV4($data['id']) : null,
        );
    }

    /**
     * @return array{
     *   id: string|null,
     *   first_name: string,
     *   last_name: string,
     *   remarks: string|null,
     *   mobile_phone: string|null,
     *   email: string|null,
     *   visitor_company: string|null,
     *   start_time: int,
     *   end_time: int,
     *   visit_reason: string,
     *   week_schedule: array<string, array<int, array{start_time: int|null, end_time: int|null}>>|null,
     *   resources: array<int, array<string, string|null>>|null
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id?->getValue(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'remarks' => $this->remarks,
            'mobile_phone' => $this->mobile_phone,
            'email' => $this->email,
            'visitor_company' => $this->visitor_company,
            'start_time' => $this->start_time->unix(),
            'end_time' => $this->end_time->unix(),
            'visit_reason' => $this->visit_reason->value,
            'week_schedule' => $this->week_schedule?->toArray(),
            'resources' => $this->resources?->map(fn ($item) => $item->toArray())->all(),
        ];
    }
}
