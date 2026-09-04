<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Simtabi\Laranail\CrmTools\ZohoOAuth\ZohoOAuth;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Facades\ZohoOAuthFacade;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider;

/**
 * THE PROVIDER COULD NOT BOOT.
 *
 * It took its whole boot() from `USIPCOM\LaraSupport\Traits\HasLaraSupportServiceProvidersTools`, a
 * package declared nowhere in composer.json and present nowhere on disk. `composer install`
 * succeeded and Laravel fataled on a missing trait the moment it registered the provider — so this
 * test is the first thing that has ever asserted the package loads at all.
 */
it('boots', function (): void {
    expect(app()->getLoadedProviders())
        ->toHaveKey(ZohoOAuthServiceProvider::class);
});

it('registers its config under vendor and slug, never a bare one', function (): void {
    expect(Config::get('laranail.crm-tools-zoho-oauth'))->toBeArray()
        ->and(Config::get('zoho-oauth'))->toBeNull();
});

it('registers translations under vendor and slug', function (): void {
    expect(Lang::getLoader()->namespaces())
        ->toHaveKey('laranail/crm-tools-zoho-oauth')
        ->and(Lang::getLoader()->namespaces())->not->toHaveKey('zoho-oauth');
});

/**
 * Container binding strings are a flat global registry too. `zoho-oauth` is a plausible collision
 * with the consuming application's own binding.
 */
it('binds the manager under a vendor-scoped key that the facade agrees with', function (): void {
    expect(app()->bound('laranail-crm-tools-zoho-oauth'))->toBeTrue()
        ->and(app()->bound('zoho-oauth'))->toBeFalse()
        ->and(ZohoOAuthFacade::getFacadeRoot())
        ->toBeInstanceOf(ZohoOAuth::class);
});

it('publishes under vendor-scoped tags', function (): void {
    $tags = ServiceProvider::publishableGroups();

    expect($tags)->toContain('laranail::crm-tools-zoho-oauth-config');
});
