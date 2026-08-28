<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Tests;

use Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider;
use Simtabi\Laranail\Package\Tools\Testing\IsolatedTestCase;

abstract class TestCase extends IsolatedTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ZohoOAuthServiceProvider::class];
    }
}
