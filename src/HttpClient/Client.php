<?php

namespace Uxicodev\UnifiAccessApi\HttpClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Uxicodev\UnifiAccessApi\API\CredentialClient;
use Uxicodev\UnifiAccessApi\API\VisitorClient;

class Client
{
    protected VisitorClient $visitorClient;
    protected CredentialClient $credentialClient;

    public function __construct(protected GuzzleHttpClient $client)
    {
        $this->visitorClient = new VisitorClient($this);
        $this->credentialClient = new CredentialClient($this);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url): ResponseInterface
    {
        return $this->client->get($url);
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws GuzzleException
     */
    public function post(string $url, array $data = []): ResponseInterface
    {
        return $this->client->post($url, ['body' => json_encode($data)]);
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws GuzzleException
     */
    public function put(string $url, array $data = []): ResponseInterface
    {
        return $this->client->put($url, ['body' => json_encode($data)]);
    }

    public function visitor(): VisitorClient
    {
        return $this->visitorClient;
    }
    public function credential(): CredentialClient
    {
        return $this->credentialClient;
    }
}
