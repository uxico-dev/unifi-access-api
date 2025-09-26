<?php

namespace Uxicodev\UnifiAccessApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Uxicodev\UnifiAccessApi\Skeleton\SkeletonClass
 */
class UnifiAccessApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'unifi-access-api';
    }
}
