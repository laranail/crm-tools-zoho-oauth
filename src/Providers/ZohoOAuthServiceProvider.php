<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Providers;

use Simtabi\Laranail\CrmTools\ZohoOAuth\Console\ZohoOAuthInitCommand;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Console\ZohoOAuthPruneCommand;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Console\ZohoOAuthRefreshCommand;
use Simtabi\Laranail\CrmTools\ZohoOAuth\ZohoOAuth;
use Simtabi\Laranail\CrmTools\ZohoOAuth\ZohoOAuthInit;
use Simtabi\Laranail\CrmTools\ZohoOAuth\ZohoOAuthRefresh;
use Simtabi\Laranail\Package\Tools\Package;
use Simtabi\Laranail\Package\Tools\Providers\PackageServiceProvider;

/**
 * This provider could not boot.
 *
 * It used `USIPCOM\LaraSupport\Traits\HasLaraSupportServiceProvidersTools` for its whole `boot()` --
 * publishAssets, loadTranslations, loadViews, loadMigrations -- and that package was **declared
 * nowhere in composer.json and present nowhere on disk**. `composer install` succeeded and the
 * provider fataled on a missing trait the moment Laravel registered it.
 *
 * `PackageServiceProvider` does the same four things from the composer name, which both replaces the
 * missing dependency and gives the package the family's vendor-scoped public names.
 */
class ZohoOAuthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name(name: 'laranail/crm-tools-zoho-oauth')
            ->hasConfigFile(configFileName: 'crm-tools-zoho-oauth')
            ->hasTranslations()
            ->hasMigrations();
    }

    public function packageRegistered(): void
    {
        foreach ([ZohoOAuthInit::class, ZohoOAuthRefresh::class] as $concrete) {
            $this->app->bind($concrete, function ($app) use ($concrete) {
                $config = $app['config']->get('laranail.crm-tools-zoho-oauth');

                return new $concrete(
                    $config['base_oauth_url'],
                    $config['client_id'],
                    $config['client_secret'],
                    $config['code'],
                );
            });
        }

        /*
         * Container binding strings are a flat global registry like any other, so this takes the
         * vendor-scoped name. `ZohoOAuthFacade::getFacadeAccessor()` returns the same string and
         * moved with it.
         */
        $this->app->singleton('laranail-crm-tools-zoho-oauth', fn (): ZohoOAuth => new ZohoOAuth);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ZohoOAuthInitCommand::class,
                ZohoOAuthRefreshCommand::class,
                ZohoOAuthPruneCommand::class,
            ]);
        }
    }
}
