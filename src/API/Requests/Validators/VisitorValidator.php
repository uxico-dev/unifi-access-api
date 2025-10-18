<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Validators;

class VisitorValidator extends AbstractValidator
{
    public function passes(): bool
    {
        if (preg_match('~^\+[1-9]\d{1,14}$~', $this->data['mobile_phone'] ?? '') < 1 && ! empty($this->data['mobile_phone'])) {
            $this->errors['mobile_phone'][] = '[mobile_phone] must be in E.164 format, e.g. +31611223344]';
        }

        return count($this->errors) === 0;
    }
}
