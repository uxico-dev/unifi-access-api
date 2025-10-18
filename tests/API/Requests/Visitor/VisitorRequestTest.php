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
}
