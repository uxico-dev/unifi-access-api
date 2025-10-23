<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\AllVisitorRequest;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\UpsertVisitorRequest;
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
    public function all(?AllVisitorRequest $request = null): VisitorsResponse
    {
        $response = $this->client->get($this::ENDPOINT. ($request !== null ? $request->toQueryString() : ''));

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorsResponse::fromArray($data);
    }

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function create(UpsertVisitorRequest $request): VisitorResponse
    {
        $response = $this->client->post($this::ENDPOINT, $request->toArray());

        $data = json_decode($response->getBody()->getContents(), true);

        return VisitorResponse::fromArray($data);
    }

    /**
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws UnifiApiErrorException
     */
    public function update(UpsertVisitorRequest $request): VisitorResponse
    {
        if ($request->id === null) {
            throw new InvalidArgumentException('Visitor ID is required for update.');
        }

        $response = $this->client->put($this::ENDPOINT."/{$request->id->getValue()}", $request->toArray());

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

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function delete(UuidV4 $visitorId): UnifiResponse
    {
        $response = $this->client->delete($this::ENDPOINT."/{$visitorId->getValue()}");

        $data = json_decode($response->getBody()->getContents(), true);

        return UnifiResponse::fromArray($data);
    }
}
