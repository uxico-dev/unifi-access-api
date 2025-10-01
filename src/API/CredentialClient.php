<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\Responses\Visitor\VisitorResponse;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\HttpClient\Client;

class CredentialClient
{
    private const ENDPOINT = 'credentials';

    public function __construct(private readonly Client $client) {}


    /**
     * @throws InvalidResponseException
     * @throws GuzzleException
     *
     * @return string Path to the temporary file containing the QR code image
     */
    public function downloadQrCode(UuidV4 $visitorId)
    {
        $response = $this->client->get($this::ENDPOINT . "/qr_codes/download/{$visitorId->getValue()}");

        if ($response->getStatusCode() !== 200) {
            throw new InvalidResponseException($response->getReasonPhrase(), $response);
        }

        $image = $response->getBody()->getContents();
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'qr_');
        file_put_contents($tmpFilePath, $image);
        return $tmpFilePath;
    }
}
