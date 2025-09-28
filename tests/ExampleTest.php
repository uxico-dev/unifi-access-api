<?php

namespace Uxicodev\UnifiAccessApi\Tests;

use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\UnifiAccessApiServiceProvider;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [UnifiAccessApiServiceProvider::class];
    }

    #[Test]
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
