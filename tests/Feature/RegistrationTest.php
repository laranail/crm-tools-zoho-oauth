<?php

declare(strict_types=1);

use Illuminate\Support\ServiceProvider;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Providers\ZohoOAuthServiceProvider;

/**
 * Every translation key the package's code asks for resolves to a message. The code called
 * trans('zoho-oauth::…') while the translations are registered under `laranail/crm-tools-zoho-oauth`,
 * so every command printed its raw key. Read from the source so a key added later is covered too.
 */
it('resolves every translation key the source uses', function (): void {
    $keys = [];
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../../src')) as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }
        preg_match_all("/(?:trans|__)\\(\\s*'([^']+::[^']+)'/", file_get_contents($file->getPathname()), $m);
        array_push($keys, ...$m[1]);
    }

    expect($keys)->not->toBeEmpty();

    foreach (array_unique($keys) as $key) {
        expect(trans($key))->not->toBe($key, "translation key [$key] does not resolve");
    }
});

/** `hasMigrations()` was called with no file names, so the table's migration was never publishable. */
it('publishes its migration under a vendor-scoped tag', function (): void {
    $paths = ServiceProvider::pathsToPublish(ZohoOAuthServiceProvider::class, 'laranail::crm-tools-zoho-oauth-migrations');

    expect($paths)->not->toBeEmpty()
        ->and(implode(' ', array_keys($paths)))->toContain('create_zoho_oauth_table');
});

/** The factory is `ZohoOAuthFactory` in the package's namespace; Laravel's naming guess cannot find it. */
it('builds models through its factory', function (): void {
    expect(ZohoOauth::factory()->make())->toBeInstanceOf(ZohoOauth::class);
});
