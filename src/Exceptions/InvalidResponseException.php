<?php

namespace Uxicodev\UnifiAccessApi\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class InvalidResponseException extends \Exception
{
    public function __construct(
        string $message,
        private readonly ?ResponseInterface $response,
        ?\Throwable $previous = null,
        private readonly ?RequestInterface $request = null,
    ) {
        parent::__construct($message, $response?->getStatusCode() ?? 500, $previous);
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }
}
