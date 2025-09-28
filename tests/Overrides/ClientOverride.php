<?php

namespace Uxicodev\UnifiAccessApi\Tests\Overrides;

use GuzzleHttp\Client as GuzzleClient;
use Uxicodev\UnifiAccessApi\API\VisitorClient;
use Uxicodev\UnifiAccessApi\HttpClient\Client;

class ClientOverride extends Client
{
    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->client = $guzzleClient;
        $this->visitor = new VisitorClient($this);
    }
}
