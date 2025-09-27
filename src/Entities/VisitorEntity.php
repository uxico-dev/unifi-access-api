<?php

namespace Uxicodev\UnifiAccessApi\Entities;

use Illuminate\Support\Collection;

class VisitorEntity
{
    /**
     * @param  Collection<array-key, string>  $license_plates
     * @param  Collection<array-key, string>  $nfc_cards
     * @param  Collection<array-key, string>  $pin_code
     * @param  Collection<array-key, ResourceEntity>  $resources
     */
    public function __construct(
        public readonly string $id,
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $inviter_id,
        public readonly string $inviter_name,
        public readonly string $avatar,
        public readonly int $create_time,
        public readonly int $end_time,
        public readonly int $start_time,
        public readonly string $status,
        public readonly string $visit_reason,
        public readonly string $visitor_company,
        public readonly string $location_id,
        public readonly string $mobile_phone,
        public readonly string $schedule_id,
        public readonly string $timezone,
        public readonly bool $has_qr_code,
        public readonly string $remarks,
        public readonly Collection $license_plates,
        public readonly Collection $nfc_cards,
        public readonly Collection $pin_code,
        public readonly Collection $resources
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? '',
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            $data['inviter_id'] ?? '',
            $data['inviter_name'] ?? '',
            $data['avatar'] ?? '',
            $data['create_time'] ?? 0,
            $data['end_time'] ?? 0,
            $data['start_time'] ?? 0,
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
