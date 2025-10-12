<?php

namespace Uxicodev\UnifiAccessApi\API;

use Uxicodev\UnifiAccessApi\Client\Client;

abstract class ApiResourceClient
{
    public function __construct(protected readonly Client $client) {}

}
