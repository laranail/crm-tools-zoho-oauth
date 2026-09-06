<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Tests;

use Simtabi\Laranail\Package\Tools\Testing\IsolatedTestCase;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider;

abstract class TestCase extends IsolatedTestCase
{
    protected function getPackageProviders($app): array
    {
        return [ZohoOAuthServiceProvider::class];
    }
}
