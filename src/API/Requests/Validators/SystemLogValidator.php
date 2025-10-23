<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\Validators;

use Carbon\Carbon;

class SystemLogValidator extends AbstractValidator
{
    protected array $required = ['topic', 'since'];

    public function passes(): bool
    {
        $valid = $this->validateRequiredFields();
        $since = $this->data['since'] ?? null;
        $until = $this->data['until'] ?? null;
        if ($since && $until) {
            $sinceCarbon = $since instanceof Carbon ? $since : Carbon::parse($since);
            $untilCarbon = $until instanceof Carbon ? $until : Carbon::parse($until);
            if ($untilCarbon->lessThanOrEqualTo($sinceCarbon)) {
                $this->errors['until'][] = "'until' must be after 'since'.";
                $valid = false;
            }
        }

        return $valid && count($this->errors) === 0;
    }
}
