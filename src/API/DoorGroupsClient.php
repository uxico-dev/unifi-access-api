<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Responses\Resource\ResourceGroupResponse;
use Uxicodev\UnifiAccessApi\Client\Client;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;

class DoorGroupsClient
{
    private const ENDPOINT = 'door_groups';

    public function __construct(private readonly Client $client) {}

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     */
    public function getTopology(): ResourceGroupResponse
    {
        $response = $this->client->get($this::ENDPOINT.'/topology');

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return ResourceGroupResponse::fromArray($data);
    }
}
