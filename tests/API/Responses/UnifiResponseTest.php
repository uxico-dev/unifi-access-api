<?php

namespace Uxicodev\UnifiAccessApi\Tests\API\Responses;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Responses\UnifiResponse;

class UnifiResponseTest extends TestCase
{
    #[Test]
    public function can_be_constructed_from_array(): void
    {
        $response = UnifiResponse::fromArray([
            'code' => '200',
            'msg' => 'Success',
        ]);
        $this->assertInstanceOf(UnifiResponse::class, $response);
        $this->assertEquals('200', $response->code);
        $this->assertEquals('Success', $response->msg);
    }
}
