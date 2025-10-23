<?php

namespace Uxicodev\UnifiAccessApi\API\Enums;

enum SystemLogTopic: string
{
    /** Fetch all logs. */
    case All = 'all';
    /** Fetch door opening logs. */
    case DoorOpenings = 'door_openings';
    /** Fetch logs for device restart, deletion, offline status, and detection. */
    case Critical = 'critical';
    /** Fetch device update logs. */
    case Updates = 'updates';
    /** Fetch logs for device online status, device updates, access policy synchronization, and active/inactive door unlock schedules. */
    case DeviceEvents = 'device_events';
    /** Fetch logs for admin activity, such as access policy updates, settings changes, and user management. */
    case AdminActivity = 'admin_activity';
    /** Fetch logs of visitor-related operations. */
    case Visitor = 'visitor';
}
