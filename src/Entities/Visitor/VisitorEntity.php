<?php

namespace Uxicodev\UnifiAccessApi\Entities\Visitor;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;

readonly class VisitorEntity
{
    /**
     * @param  Collection<array-key, string>  $license_plates
     * @param  Collection<array-key, string>  $nfc_cards
     * @param  Collection<array-key, string>  $pin_code
     * @param  Collection<array-key, ResourceEntity>  $resources
     */
    public function __construct(
        public UuidV4 $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $inviter_id,
        public string $inviter_name,
        public string $avatar,
        public Carbon $create_time,
        public Carbon $end_time,
        public Carbon $start_time,
        public string $status,
        public string $visit_reason,
        public string $visitor_company,
        public string $location_id,
        public string $mobile_phone,
        public string $schedule_id,
        public string $timezone,
        public bool $has_qr_code,
        public string $remarks,
        public Collection $license_plates,
        public Collection $nfc_cards,
        public Collection $pin_code,
        public Collection $resources
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new UuidV4($data['id']),
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            $data['inviter_id'] ?? '',
            $data['inviter_name'] ?? '',
            $data['avatar'] ?? '',
            Carbon::parse($data['create_time']),
            Carbon::parse($data['end_time']),
            Carbon::parse($data['start_time']),
            $data['status'] ?? '',
            $data['visit_reason'] ?? '',
            $data['visitor_company'] ?? '',
            $data['location_id'] ?? '',
            $data['mobile_phone'] ?? '',
            $data['schedule_id'] ?? '',
            $data['timezone'] ?? '',
            $data['has_qr_code'] ?? false,
            $data['remarks'] ?? '',
            collect($data['license_plates'] ?? []),
            collect($data['nfc_cards'] ?? []),
            collect($data['pin_code'] ?? []),
            collect(array_map([ResourceEntity::class, 'fromArray'], $data['resources'] ?? []))
        );
    }
}
