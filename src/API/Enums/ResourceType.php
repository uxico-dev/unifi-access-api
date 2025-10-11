<?php

namespace Uxicodev\UnifiAccessApi\API\Enums;

enum ResourceType: string
{
    case Door = 'door';
    case DoorGroup = 'door_group';

    case Floor = 'floor';
    case Building = 'building';
}
