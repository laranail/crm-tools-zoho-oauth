<?php declare(strict_types=1);

namespace USIPCOM\ZohoOAuth\Facades;

use Illuminate\Support\Facades\Facade;

class ZohoOAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'zoho-oauth';
    }
}
