# Getting started

Store your first Zoho tokens, keep the access token fresh, and use it to call a Zoho API.

This assumes [Installation](installation.md) is done: credentials are in `.env` and the `zoho_oauth` table exists.

## Store the first tokens

Run the init command whenever you have a new grant `code`. It exchanges the code for a `refresh_token` and an `access_token` and adds a row to the `zoho_oauth` table:

```bash
php artisan laranail::crm-tools-zoho-oauth.init
```

It fails when:

1. The application is not connected to the internet.
2. `ZOHO_CLIENT_ID`, `ZOHO_CLIENT_SECRET` or `ZOHO_CODE` is invalid, or the code has expired or was already used.

## Generate an access token from the refresh token

To generate a new `access_token` at any time:

```bash
php artisan laranail::crm-tools-zoho-oauth.refresh
```

This adds a row carrying a new `access_token`, the existing `refresh_token`, and an expiry taken from Zoho's `expires_in` (usually one hour).

## Keep the access token fresh

The `access_token` expires after a set period, usually one hour; after that the `refresh_token` is used to generate a new one. Schedule the refresh at an interval shorter than that, in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('laranail::crm-tools-zoho-oauth.refresh')->everyThirtyMinutes();
```

Laravel 11 and later have no `app/Console/Kernel.php` by default, so the scheduler lives in `routes/console.php`. [Schedule token maintenance](recipes/schedule-token-maintenance.md) adds pruning to the same file.

## Use the token

Read the latest row and send its `auth_token` as the `Authorization` header:

```php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth;

class ZohoController extends Controller
{
    public function index()
    {
        $token = ZohoOauth::latest()->first()?->auth_token;
        // "Zoho-oauthtoken 1000.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy"

        $response = Http::withHeaders(['Authorization' => $token])
            ->get('https://www.zohoapis.com/crm/v2/Leads');

        // ...
    }
}
```

## Delete old tokens

Every refresh adds a row, so the table grows. `laranail::crm-tools-zoho-oauth.prune` keeps the 10 most recent rows and deletes the rest; schedule it daily as shown in [Schedule token maintenance](recipes/schedule-token-maintenance.md).

## Revoke a token

Not implemented. Earlier docs described loading a token and calling `->revoke()`, but no such method exists on the model or the services; revoke tokens from the Zoho API console for now.

---

[← Docs index](../README.md#documentation)
