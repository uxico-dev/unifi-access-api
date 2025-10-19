<?php

namespace Uxicodev\UnifiAccessApi;

use GuzzleHttp\Client as GuzzleHttpClient;
use Uxicodev\UnifiAccessApi\Client\Client;

class UnifiAccessApi
{
    /**
     * @param  array<string, mixed>  $options
     */
    public function getClient(array $options = []): Client
    {
        $guzzleClient = new GuzzleHttpClient(
            array_merge(
                [
                    'base_uri' => config('unifi-access-api.unifi.uri'),
                    'headers' => [
                        'Authorization' => config('unifi-access-api.unifi.api_key'),
                        'Accept' => 'application/json',
                    ],
                    'verify' => config('unifi-access-api.unifi.ssl_verify'),
                ],
                $options
            )
        );

        return new Client($guzzleClient);
    }
}
