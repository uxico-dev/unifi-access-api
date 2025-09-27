<?php

namespace Uxicodev\UnifiAccessApi;

use Uxicodev\UnifiAccessApi\HttpClient\Client;

class UnifiAccessApi
{
    /**
     * @param  array<string, mixed>  $options
     */
    public function getClient(array $options = []): Client
    {
        return new Client(
            config('unifi-access-api.unifi.uri'),
            config('unifi-access-api.unifi.api_key'),
            array_merge(['verify' => config('unifi-access-api.unifi.ssl_verify')], $options)
        );
    }
}
