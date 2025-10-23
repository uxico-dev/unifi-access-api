<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Validators;

use Illuminate\Contracts\Support\MessageBag as MessageBagContract;
use Illuminate\Support\MessageBag;

abstract class AbstractValidator implements ValidatorContract
{
    /** @var array<string, array<array-key, string>> */
    protected array $errors = [];

    /**
     * @var string[]
     */
    protected array $required = [];

    /**
     * @param  array<array-key, mixed>  $data
     */
    public function __construct(protected readonly array $data) {}

    protected function validateRequiredFields(): bool
    {
        $valid = true;
        foreach ($this->required as $field) {
            if (! array_key_exists($field, $this->data) || $this->data[$field] === null || $this->data[$field] === '') {
                $this->errors[$field][] = "The field '{$field}' is required.";
                $valid = false;
            }
        }

        return $valid;
    }

    public function getErrors(): MessageBagContract
    {
        return new MessageBag($this->errors);
    }
}
