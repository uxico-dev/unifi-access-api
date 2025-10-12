<?php

namespace Uxicodev\UnifiAccessApi\Client;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Uxicodev\UnifiAccessApi\API\CredentialClient;
use Uxicodev\UnifiAccessApi\API\DoorGroupsClient;
use Uxicodev\UnifiAccessApi\API\VisitorClient;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;

class Client
{
    protected VisitorClient $visitorClient;

    protected CredentialClient $credentialClient;

    protected DoorGroupsClient $doorGroupsClient;

    public function __construct(protected GuzzleHttpClient $client)
    {
        $this->visitorClient = new VisitorClient($this);
        $this->credentialClient = new CredentialClient($this);
        $this->doorGroupsClient = new DoorGroupsClient($this);
    }

    /**
     * @throws InvalidResponseException|UnifiApiErrorException|GuzzleException
     */
    public function get(string $url): ResponseInterface
    {
        try {
            $response = $this->client->get($url);
        } catch (RequestException $clientException) {
            $responseBody = $clientException->getResponse()?->getBody()->getContents() ?? '[Response body was empty]';
            $clientException->getResponse()?->getBody()->rewind();
            throw new InvalidResponseException($responseBody, $clientException->getResponse(), $clientException, $clientException->getRequest());
        }
        $this->throwExceptionOnInvalidUnifiResponse($response);

        return $response;
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws InvalidResponseException|UnifiApiErrorException|GuzzleException
     */
    public function post(string $url, array $data = []): ResponseInterface
    {
        try {
            $response = $this->client->post($url, ['body' => json_encode($data)]);
        } catch (RequestException $clientException) {
            $responseBody = $clientException->getResponse()?->getBody()->getContents() ?? '[Response body was empty]';
            $clientException->getResponse()?->getBody()->rewind();
            throw new InvalidResponseException($responseBody, $clientException->getResponse(), $clientException, $clientException->getRequest());
        }
        $this->throwExceptionOnInvalidUnifiResponse($response);

        return $response;
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws InvalidResponseException|UnifiApiErrorException|GuzzleException
     */
    public function put(string $url, array $data = []): ResponseInterface
    {
        try {
            $response = $this->client->put($url, ['body' => json_encode($data)]);
        } catch (RequestException $clientException) {
            $responseBody = $clientException->getResponse()?->getBody()->getContents() ?? '[Response body was empty]';
            $clientException->getResponse()?->getBody()->rewind();
            throw new InvalidResponseException($responseBody, $clientException->getResponse(), $clientException, $clientException->getRequest());
        }
        $this->throwExceptionOnInvalidUnifiResponse($response);

        return $response;
    }

    public function visitor(): VisitorClient
    {
        return $this->visitorClient;
    }

    public function credential(): CredentialClient
    {
        return $this->credentialClient;
    }

    public function doorGroups(): DoorGroupsClient
    {
        return $this->doorGroupsClient;
    }

    /**
     * @throws InvalidResponseException
     * @throws UnifiApiErrorException
     */
    private function throwExceptionOnInvalidUnifiResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $responseBody = json_decode($response->getBody()->getContents(), true);
        if (strtoupper($responseBody['code']) !== 'SUCCESS') {
            throw new UnifiApiErrorException(sprintf('Code: [%s], Message: [%s]', $responseBody['code'], $responseBody['msg'] ?? 'Unknown unifi response'), $response);
        }
        $response->getBody()->rewind();
    }
}
