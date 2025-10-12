<?php

namespace Uxicodev\UnifiAccessApi\API;

use GuzzleHttp\Exception\GuzzleException;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Exceptions\InvalidResponseException;
use Uxicodev\UnifiAccessApi\Exceptions\UnifiApiErrorException;

class CredentialClient extends ApiResourceClient
{
    private const ENDPOINT = 'credentials';

    /**
     * @return string Path to the temporary file containing the QR code image
     *
     * @throws InvalidResponseException
     * @throws GuzzleException
     * @throws UnifiApiErrorException
     */
    public function downloadQrCode(UuidV4 $visitorId): string
    {
        $response = $this->client->get($this::ENDPOINT."/qr_codes/download/{$visitorId->getValue()}");

        $image = $response->getBody()->getContents();
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'qr_');
        file_put_contents($tmpFilePath, $image);

        return $tmpFilePath;
    }
}
