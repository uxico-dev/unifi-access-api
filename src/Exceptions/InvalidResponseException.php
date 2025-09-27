<?php

namespace Uxicodev\UnifiAccessApi\Exceptions;

use Psr\Http\Message\ResponseInterface;

class InvalidResponseException extends \Exception
{
    public function __construct(
        string $message,
        private ResponseInterface $response,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $response->getStatusCode(), $previous);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
