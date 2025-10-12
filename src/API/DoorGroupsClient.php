<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Responses\Resource\ResourceGroupResponse;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;

class DoorGroupsClient extends ApiResourceClient
{
    private const ENDPOINT = 'door_groups';

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function getTopology(): ResourceGroupResponse
    {
        $response = $this->client->get($this::ENDPOINT.'/topology');

        $data = json_decode($response->getBody()->getContents(), true);

        return ResourceGroupResponse::fromArray($data);
    }
}
