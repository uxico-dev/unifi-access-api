<?php

declare(strict_types=1);

namespace Uxicodev\UnifiAccessApi\API\Enums;

/**
 * Enum for expand[] query parameter in VisitorClient::all
 *
 * UniFi Access Requirement: 1.22.16 or later
 *
 * - none: No object will be returned
 * - access_policy
 * - resource
 * - schedule
 * - nfc_card
 * - pin_code
 */
enum Expand: string
{
    case NONE = 'none';
    case ACCESS_POLICY = 'access_policy';
    case RESOURCE = 'resource';
    case SCHEDULE = 'schedule';
    case NFC_CARD = 'nfc_card';
    case PIN_CODE = 'pin_code';
}
