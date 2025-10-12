<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\CreateVisitorRequest;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;
use Uxicodev\UnifiAccessApi\API\Responses\Visitor\VisitorResponse;
use Uxicodev\UnifiAccessApi\API\Responses\Visitor\VisitorsResponse;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;

class VisitorClient extends ApiResourceClient
{
    private const ENDPOINT = 'visitors';

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function find(UuidV4 $visitorId): VisitorResponse
    {
        $response = $this->client->get($this::ENDPOINT."/{$visitorId->getValue()}");

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function all(): VisitorsResponse
    {
        $response = $this->client->get($this::ENDPOINT);

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorsResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function create(CreateVisitorRequest $request): VisitorResponse
    {
        $response = $this->client->post($this::ENDPOINT, $request->toArray());

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function assignQrCode(UuidV4 $visitorId): UnifiResponse
    {
        $response = $this->client->put($this::ENDPOINT."/{$visitorId->getValue()}/qr_codes");

        $data = json_decode($response->getBody()->getContents(), true);

        return UnifiResponse::fromArray($data);
    }
}
