<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Console;

use Illuminate\Console\Command;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Services\ZohoOAuthRefresh;

class ZohoOAuthRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoauth:refresh';

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
