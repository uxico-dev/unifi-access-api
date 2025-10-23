<?php

declare(strict_types=1);

namespace Uxicodev\UnifiAccessApi\Tests\API\Requests\Visitor;

use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Enums\Expand;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\AllVisitorRequest;

class AllVisitorRequestTest extends TestCase
{
    public function test_default_query_string_is_empty(): void
    {
        $request = new AllVisitorRequest();
        $this->assertSame('', $request->toQueryString());
    }

    public function test_query_string_with_all_params(): void
    {
        $request = new AllVisitorRequest(
            status: 2,
            keyword: 'John',
            page_num: 3,
            page_size: 25,
            expand: [Expand::ACCESS_POLICY, Expand::RESOURCE]
        );
        $query = $request->toQueryString();
        $this->assertStringContainsString('status=2', $query);
        $this->assertStringContainsString('keyword=John', $query);
        $this->assertStringContainsString('page_num=3', $query);
        $this->assertStringContainsString('page_size=25', $query);
        $this->assertStringContainsString('expand%5B0%5D=access_policy', $query);
        $this->assertStringContainsString('expand%5B1%5D=resource', $query);
        $this->assertStringStartsWith('?', $query);
    }

    public function test_query_string_with_empty_expand(): void
    {
        $request = new AllVisitorRequest(expand: []);
        $this->assertSame('', $request->toQueryString());
    }
}

