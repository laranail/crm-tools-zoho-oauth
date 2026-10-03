<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Services\ZohoOAuthInit;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Services\ZohoOAuthRefresh;

/**
 * The provider bound `...\ZohoOAuth\ZohoOAuthInit` and `...\ZohoOAuthRefresh`, a namespace with no
 * such classes, while the commands resolve the real ones under `Services\`. Those had no binding,
 * so the container tried to autowire four `string` constructor parameters and both `zoauth:init`
 * and `zoauth:refresh` threw a BindingResolutionException when run -- parsing cleanly, and failing
 * only at the moment someone needed a token.
 */
dataset('services', [ZohoOAuthInit::class, ZohoOAuthRefresh::class]);

it('resolves the service the commands use, built from the package config', function (string $service): void {
    Config::set('laranail.crm-tools-zoho-oauth.base_oauth_url', 'https://accounts.zoho.com/oauth/v2/');
    Config::set('laranail.crm-tools-zoho-oauth.client_id', '1000.ACMECLIENT');
    Config::set('laranail.crm-tools-zoho-oauth.client_secret', 'acme-secret');
    Config::set('laranail.crm-tools-zoho-oauth.code', '1000.grant-code');

    expect(app($service))->toBeInstanceOf($service);
})->with('services');
