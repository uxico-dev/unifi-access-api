<?php

namespace Uxicodev\UnifiAccessApi\Tests;

use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Uxicodev\UnifiAccessApi\UnifiAccessApi;
use Uxicodev\UnifiAccessApi\UnifiAccessApiFacade;
use Uxicodev\UnifiAccessApi\UnifiAccessApiServiceProvider;

class UnifiAccessApiFacadeTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            UnifiAccessApiServiceProvider::class,
        ];
    }

    #[Test]
    public function it_can_instantiate_the_facade(): void
    {
        $instance = UnifiAccessApiFacade::getFacadeRoot();

        $this->assertInstanceOf(UnifiAccessApi::class, $instance);
    }
}
