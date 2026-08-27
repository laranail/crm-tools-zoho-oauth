<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ZohoOAuthServiceProvider::class];
    }
}
