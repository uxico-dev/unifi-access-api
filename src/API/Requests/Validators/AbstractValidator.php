<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Validators;

use Illuminate\Contracts\Support\MessageBag as MessageBagContract;
use Illuminate\Support\MessageBag;

abstract class AbstractValidator implements ValidatorContract
{
    /** @var array<string, array<array-key, string>> */
    protected array $errors = [];

    /**
     * @param  array<array-key, mixed>  $data
     */
    public function __construct(protected readonly array $data) {}

    public function getErrors(): MessageBagContract
    {
        return new MessageBag($this->errors);
    }
}
