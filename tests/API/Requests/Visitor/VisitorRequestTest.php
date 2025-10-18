<?php

namespace Uxicodev\UnifiAccessApi\Tests\API\Requests\Visitor;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Uxicodev\UnifiAccessApi\API\Enums\VisitReason;
use Uxicodev\UnifiAccessApi\API\Requests\Visitor\VisitorRequest;
use Uxicodev\UnifiAccessApi\Exceptions\ValidationException;

class VisitorRequestTest extends TestCase
{
    #[Test]
    public function construct_throws_error_when_phone_number_is_not_e164_compliant(): void
    {
        $this->expectException(ValidationException::class);
        new VisitorRequest(
            'John',
            'Doe',
            now(),
            now(),
            VisitReason::Others,
            mobile_phone: '0611223344'
        );
    }

    #[Test]
    public function can_be_constructed_from_array(): void
    {
        $data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'start_time' => now(),
            'end_time' => now()->addHours(2),
            'visit_reason' => 'Business',
            'mobile_phone' => '+1234567890',
        ];

        $visitorRequest = VisitorRequest::fromArray($data);

        $this->assertInstanceOf(VisitorRequest::class, $visitorRequest);
        $this->assertEquals('Jane', $visitorRequest->first_name);
        $this->assertEquals('Doe', $visitorRequest->last_name);
        $this->assertEquals(VisitReason::Business, $visitorRequest->visit_reason);
        $this->assertEquals('+1234567890', $visitorRequest->mobile_phone);
    }
}
