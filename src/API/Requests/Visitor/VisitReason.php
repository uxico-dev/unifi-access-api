<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

enum VisitReason: string
{
    case Interview = 'Interview';
    case Business = 'Business';
    case Cooperation = 'Cooperation';
    case Others = 'Others';

}
