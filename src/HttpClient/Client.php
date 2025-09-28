<?php

namespace Uxicodev\UnifiAccessApi\HttpClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Uxicodev\UnifiAccessApi\API\VisitorClient;

class Client
{
    protected GuzzleHttpClient $client;

    protected VisitorClient $visitor;

    /**
     * @param  array<string, string>  $options
     */
    public function __construct(string $baseUri, string $apiKey, array $options = [])
    {
        $this->client = new GuzzleHttpClient(array_merge([
            'base_uri' => $baseUri,
            'headers' => [
                'Authorization' => "Bearer {$apiKey}",
                'Accept' => 'application/json',
            ],
        ], $options));

        $this->visitor = new VisitorClient($this);
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
        return $this->visitor;
    }
}
