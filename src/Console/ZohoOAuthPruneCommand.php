<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Console;

use Simtabi\Laranail\Package\Tools\Commands\Command;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth;

class ZohoOAuthPruneCommand extends Command
{
    const TOKENS_TO_RETAIN = 10;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laranail::crm-tools-zoho-oauth.prune';

    /**
     * `zoauth:prune` was this command's name until 0.1.
     *
     * Outside the vendor scope, so package-tools' base command prints a deprecation line naming
     * the replacement whenever it is invoked by it, then runs as before.
     *
     * @deprecated `zoauth:prune` is removed no earlier than the next minor after 0.1; use
     *             `laranail::crm-tools-zoho-oauth.prune`.
     *
     * @var array<int, string>
     */
    protected $aliases = ['zoauth:prune'];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all except the recent 10 Zoho Oauth tokens from database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tokenCount = ZohoOauth::count();

        if ($tokenCount === 0) {
            $this->warn(trans('laranail/crm-tools-zoho-oauth::zoauth.db_empty'));

            return 0;
        }

        ZohoOauth::latest()
            ->skip(self::TOKENS_TO_RETAIN)
            ->take($tokenCount)
            ->get()
            ->each(fn ($row) => $row->delete());

        $this->info('Old tokens removed successfully');

        return 0;
    }
}
