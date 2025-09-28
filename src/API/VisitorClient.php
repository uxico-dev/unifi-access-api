<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\API\Responses\Visitor\VisitorResponse;
use Uxicodev\UnifiAccessApi\API\Responses\Visitor\VisitorsResponse;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\HttpClient\Client;

class VisitorClient
{
    private const ENDPOINT = 'visitors';

    public function __construct(private readonly Client $client) {}

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     */
    public function find(UuidV4 $visitorId): VisitorResponse
    {
        $response = $this->client->get($this::ENDPOINT."/{$visitorId->getValue()}");

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     */
    public function all(): VisitorsResponse
    {
        $response = $this->client->get($this::ENDPOINT);

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorsResponse::fromArray($data);
    }

    public function create(CreateVisitorRequest $request): VisitorResponse
    {
        $response = $this->client->post($this::ENDPOINT, $request->toArray());

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     */
    public function assignQrCode(UuidV4 $visitorId): UnifiResponse
    {
        $response = $this->client->put($this::ENDPOINT."/{$visitorId->getValue()}/qr_codes");

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return UnifiResponse::fromArray($data);
    }
}
