<?php

namespace Uxicodev\UnifiAccessApi\API\Requests\System;

use Carbon\Carbon;
use Uxicodev\UnifiAccessApi\API\Enums\SystemLogTopic;
use Uxicodev\UnifiAccessApi\API\Requests\Validators\SystemLogValidator;
use Uxicodev\UnifiAccessApi\API\ValueObjects\UuidV4;
use Uxicodev\UnifiAccessApi\Exceptions\ValidationException;

readonly class SystemLogRequest
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public SystemLogTopic $topic,
        public Carbon $since,
        public ?Carbon $until = null,
        public ?UuidV4 $actor_id = null,
        public ?int $page_size = null,
        public ?int $page_num = null
    ) {
        $this::validate($this->toArray());
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public static function fromArray(array $data): self
    {
        self::validate($data);
        $since = Carbon::parse($data['since']);
        $until = isset($data['until']) ? Carbon::parse($data['until']) : null;

        return new self(
            SystemLogTopic::from($data['topic']),
            $since,
            $until,
            isset($data['actor_id']) ? new UuidV4($data['actor_id']) : null,
            $data['page_size'] ?? null,
            $data['page_num'] ?? null
        );
    }

    /**
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    private static function validate(array $data): void
    {
        $validator = new SystemLogValidator($data);
        if (! $validator->passes()) {
            throw new ValidationException(
                errors: $validator->getErrors(),
                message: 'SystemLogRequest validation failed.'
            );
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'topic' => $this->topic->value,
            'since' => $this->since->unix(),
            'until' => $this->until?->unix(),
            'actor_id' => $this->actor_id?->getValue(),
            'page_size' => $this->page_size,
            'page_num' => $this->page_num,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getQueryParams(): array
    {
        return [
            'page_size' => $this->page_size,
            'page_num' => $this->page_num,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getPostBody(): array
    {
        return [
            'topic' => $this->topic->value,
            'since' => $this->since->unix(),
            'until' => $this->until?->unix(),
            'actor_id' => $this->actor_id?->getValue(),
        ];
    }
}
