<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Contracts;

interface ZohoCredentialsInterface
{
    public function prepareData(array $responseData): array;
}
