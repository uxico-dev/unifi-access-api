<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Validators;

use Illuminate\Contracts\Support\MessageBag;

interface ValidatorContract
{
    public function passes(): bool;

    public function getErrors(): MessageBag;
}
