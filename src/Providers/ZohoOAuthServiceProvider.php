<?php declare(strict_types=1);

namespace USIPCOM\ZohoOAuth\Providers;

use Illuminate\Support\ServiceProvider;
use USIPCOM\LaraSupport\Traits\HasLaraSupportServiceProvidersTools;
use USIPCOM\ZohoOAuth\Console\ZohoOAuthInitCommand;
use USIPCOM\ZohoOAuth\Console\ZohoOAuthPruneCommand;
use USIPCOM\ZohoOAuth\Console\ZohoOAuthRefreshCommand;
use USIPCOM\ZohoOAuth\ZohoOAuth;

class ZohoOAuthServiceProvider extends ServiceProvider
{

    use HasLaraSupportServiceProvidersTools;

    private string $namespace = 'zoho-oauth';
    private string $name      = 'zoho-oauth';
    private string $path      = __DIR__.'/../../';

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(ZohoOAuthInit::class, function ($app) {
            $config = $app['config']->get('zoho-oauth');

            return new ZohoOAuthInit(
                $config['base_oauth_url'],
                $config['client_id'],
                $config['client_secret'],
                $config['code']);
        });

        $this->app->bind(ZohoOAuthRefresh::class, function ($app) {
            $config = $app['config']->get('zoho-oauth');

            return new ZohoOAuthRefresh(
                $config['base_oauth_url'],
                $config['client_id'],
                $config['client_secret'],
                $config['code']
            );
        });

        // Register the main class to use with the facade
        $this->app->singleton('zoho-oauth', function () {
            return new ZohoOAuth();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                ZohoOAuthInitCommand::class,
                ZohoOAuthRefreshCommand::class,
                ZohoOAuthPruneCommand::class,
            ]);
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // load package assets
        $this
            ->publishAssets(name: $this->name, path: $this->path, namespace: $this->generatePackageNamespace($this->namespace))
            ->loadTranslations(path: $this->path, namespace: $this->generatePackageNamespace($this->namespace))
            ->loadViews(path: $this->path, namespace: $this->generatePackageNamespace($this->namespace))
            ->loadMigrations(path: $this->path);
    }

}
