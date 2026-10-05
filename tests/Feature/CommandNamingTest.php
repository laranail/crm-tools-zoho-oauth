<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Simtabi\Laranail\Package\Tools\Testing\NamingScope;
use Simtabi\Laranail\Package\Tools\Testing\AssertsRegisteredNames;

uses(AssertsRegisteredNames::class);

/**
 * Artisan command names, read from the live console kernel.
 *
 * `zoauth:*` were the names until 0.1. They stay as aliases that print a deprecation line and then
 * run the command, until the next minor after 0.1. Ownership is judged from `src/`, because
 * package-tools v0.1.3 defaults to the package root, which here also holds `vendor/`.
 */
const ZOHO_OAUTH_DEPRECATED_COMMANDS = [
    'zoauth:init'    => 'laranail::crm-tools-zoho-oauth.init',
    'zoauth:refresh' => 'laranail::crm-tools-zoho-oauth.refresh',
    'zoauth:prune'   => 'laranail::crm-tools-zoho-oauth.prune',
];

it('registers every command under laranail::crm-tools-zoho-oauth.<command>', function (): void {
    $scope = NamingScope::for(
        'laranail/crm-tools-zoho-oauth',
        'Simtabi\\Laranail\\CrmTools\\ZohoOAuth\\',
        basePath: dirname(__DIR__, 2) . '/src',
    );

    $scoped = $this->assertCommandNamesScoped(
        $scope,
        deprecated: array_keys(ZOHO_OAUTH_DEPRECATED_COMMANDS),
        atLeast: 3,
    );

    expect($scoped)->toContain(...array_values(ZOHO_OAUTH_DEPRECATED_COMMANDS));
});

it('keeps each old name as an alias of its scoped command', function (): void {
    $commands = Artisan::all();

    foreach (ZOHO_OAUTH_DEPRECATED_COMMANDS as $old => $new) {
        expect($commands)->toHaveKey($old)
            ->and($commands[$old])->toBe($commands[$new])
            ->and($commands[$new]->isDeprecatedAlias($old))->toBeTrue()
            ->and($commands[$new]->isDeprecatedAlias($new))->toBeFalse();
    }
});

it('warns when invoked by a deprecated name, then runs as before', function (): void {
    config()->set('database.default', 'testing');
    config()->set('database.connections.testing', ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']);
    (include dirname(__DIR__, 2) . '/database/migrations/create_zoho_oauth_table.php')->up();

    $exit = Artisan::call('zoauth:prune');
    $output = Artisan::output();

    expect($exit)->toBe(0)
        ->and($output)->toContain('[zoauth:prune] is a deprecated alias')
        ->toContain('laranail::crm-tools-zoho-oauth.prune')
        ->toContain(trans('laranail/crm-tools-zoho-oauth::zoauth.db_empty'));

    Artisan::call('laranail::crm-tools-zoho-oauth.prune');

    expect(Artisan::output())->not->toContain('deprecated');
});
