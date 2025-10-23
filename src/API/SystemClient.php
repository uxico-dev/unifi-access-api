<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Requests\System\SystemLogRequest;
use Uxicodev\UnifiAccessApi\API\Responses\System\SystemLogsResponse;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;

class SystemClient extends ApiResourceClient
{
    private const ENDPOINT = 'system';

    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function logs(SystemLogRequest $request): SystemLogsResponse
    {
        $response = $this->client->post($this::ENDPOINT.'/logs?'.http_build_query($request->getQueryParams()),
            $request->getPostBody()
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return SystemLogsResponse::fromArray($data);
    }
}
