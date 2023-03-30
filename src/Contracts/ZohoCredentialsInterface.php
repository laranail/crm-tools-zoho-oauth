<?php declare(strict_types=1);

namespace USIPCOM\ZohoOAuth\Contracts;

interface ZohoCredentialsInterface
{
    public function prepareData(array $responseData): array;
}
