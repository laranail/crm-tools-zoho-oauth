<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Console;

use Simtabi\Laranail\Package\Tools\Commands\Command;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Services\ZohoOAuthRefresh;

class ZohoOAuthRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laranail::crm-tools-zoho-oauth.refresh';

    /**
     * `zoauth:refresh` was this command's name until 0.1.
     *
     * Outside the vendor scope, so package-tools' base command prints a deprecation line naming
     * the replacement whenever it is invoked by it, then runs as before.
     *
     * @deprecated `zoauth:refresh` is removed no earlier than the next minor after 0.1; use
     *             `laranail::crm-tools-zoho-oauth.refresh`.
     *
     * @var array<int, string>
     */
    protected $aliases = ['zoauth:refresh'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new access token from refresh token.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(app(ZohoOAuthRefresh::class)->generateNewRefreshToken());

        return 0;
    }
}
