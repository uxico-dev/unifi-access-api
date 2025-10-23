<?php

declare(strict_types=1);

namespace Uxicodev\UnifiAccessApi\API\Requests\Visitor;

use Uxicodev\UnifiAccessApi\API\Enums\Expand;

readonly class AllVisitorRequest
{
    public function __construct(
        public ?int $status = null,
        public ?string $keyword = null,
        public ?int $page_num = null,
        public ?int $page_size = null,
        /** @var Expand[]|null $expand */
        public ?array $expand = null,
    ) {}

    /**
     * Returns the query string for the request, using http_build_query and correct expand[] handling.
     */
    public function toQueryString(): string
    {
        $query = [];
        if ($this->status !== null) {
            $query['status'] = $this->status;
        }
        if ($this->keyword !== null) {
            $query['keyword'] = $this->keyword;
        }
        if ($this->page_num !== null) {
            $query['page_num'] = $this->page_num;
        }
        if ($this->page_size !== null) {
            $query['page_size'] = $this->page_size;
        }
        if ($this->expand) {
            $query['expand'] = array_map(fn (Expand $e) => $e->value, $this->expand);
        }

        return $query ? '?'.http_build_query($query) : '';
    }
}
